<?php

namespace App\Http\Controllers\Backend\Report\Commissary\Summary;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Order\Order;
use App\Models\OrderList\OrderList;
use App\Models\Commissary\Dispose\Dispose;
use App\Models\Commissary\GoodsReturn\GoodsReturn;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Stock\Stock;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\Delivery\Delivery;
use App\Models\Inventory\Inventory as POS;

class ReportController extends Controller
{
    public function index(){
    	$to 	  = date('Y-m-d', strtotime('sunday'));
    	$from 	  = date('Y-m-d', strtotime($to.' -6 day'));
    	$reports  = $this->fetch_inventories($from, $to);
        $products = $this->fetch_products($from, $to);

    	return view('backend.report.commissary.summary.index', compact('reports', 'products', 'from', 'to'));
    }

    public function store(Request $request){
        $to      = date('Y-m-d', strtotime($request->to));
        $from    = date('Y-m-d', strtotime($request->from));
        $reports = $this->fetch_inventories($from, $to);
        $products = $this->fetch_products($from, $to);

        return view('backend.report.commissary.summary.index', compact('reports', 'products', 'from', 'to'));
    }

    public function fetch_inventories($from, $to){
        $reports     = [];
        $categories  = Category::all();

        foreach($categories as $category)
        {
            $index       = 0;
            $report      = [];
            $inventories = Inventory::where('category_id', $category->id)->get();

            foreach ($inventories as $inventory) 
            {
                $report[$index] = (object)[
                                    'name'      => $inventory->name,
                                    'unit'      => $inventory->unit_type,
                                    'beginning' => $this->beginning($inventory->id, $from, $to),
                                    'delivery'  => $this->delivery($inventory->id, $from, $to),
                                    'sale'      => $this->sales($inventory->id, $from, $to),
                                    'dispose'   => $this->dispose($inventory->id, $from, $to),
                                    'goods'     => $this->goods_return($inventory->id, $from, $to),
                                    'ending'    => $inventory->stock,
                                    'actual'    => $this->actual($inventory->id, $from, $to)
                                  ];
                $index++;
            }

            $reports[strtolower($category->name)] = (object)[
                                                        'category' => $category->name,
                                                        'summaries'  => $report
                                                    ];
        }

        return $reports;
    }

    public function fetch_products($from, $to){
        $index    = 0;
        $reports  = [];
        $category = Category::where('name', 'fruit')->first();
        $products = Product::where('category_id', $category->id)->get();

        foreach($products as $product)
        {
            $reports[$index] = (object)[
                                    'name'      => $product->name,
                                    'unit'      => 'unknown',
                                    'beginning' => $this->product_beginning($product->id, $from, $to),
                                    'delivery'  => $this->product_delivery($product->id, $from, $to),
                                    'sale'      => $this->product_sales($product->id, $from, $to),
                                    'dispose'   => $this->product_dispose($product->id, $from, $to),
                                    'goods'     => 'goods return',
                                    'ending'    => $product->produce,
                                    'actual'    => $product->produce
                                ];

            $index++;
        }

        return $reports;
    }

    public function beginning($inventory_id, $from, $to){
    	$cost     = 0;
        $quantity = 0;
        $used_qty = 0;
    	$sales    = $this->sales($inventory_id, $from, $to)->quantity;
    	$inventory= Inventory::with(['stocks' => function($q) use($from, $to) {
                        $q->whereBetween('received', [$from, $to]);
                    }, 'products'])
                    ->where('id', $inventory_id)->first();

        $deliveries = Delivery::where('item_id', $inventory->id)
                    ->where('type', 'RAW MATERIAL')
                    ->get();

        $product = Product::with(['ingredients' => function($q) use($inventory_id) {
                        $q->where('inventory_id', $inventory_id);
                    }, 'produced' => function($q) use($from, $to) {
                        $q->whereBetween('date', [$from, $to]);
                    }])->first();


        foreach($deliveries as $delivery)
        {
            $used_qty = $used_qty + $delivery->quantity;
        }

        if(count($product))
        {
            $temp  = 0;
            $temp2 = 0;

            if(count($product->ingredients))
            {
                $temp = $product->ingredients->first()->pivot->quantity;
            }

            if(count($product->produced))
            {
                $temp2 = $product->produced->first()->quantity;
            }

            $used_qty = $used_qty + ($temp * $temp2);
        }

    	if(count($inventory->stocks))
    	{
    		$cost = $inventory->stocks->last()->price;
    	}
        else
        {
            $cost = count($inventory->stocks) ? $inventory->stocks->last()->price : 0;
        }

        $quantity = $inventory->stock + $used_qty;

    	$obj = (object)[
    					'quantity' => $quantity, 
    					'cost'	   => $cost
    				   ];

    	return $obj;
    }

    public function delivery($inventory_id, $from, $to){
    	$stocks = 0;
        $cost   = 0;

        $deliveries = Delivery::where('item_id', $inventory_id)
                    ->whereBetween('date', [$from, $to])
                    ->where('type', 'RAW MATERIAL')
                    ->get();

        foreach($deliveries as $delivery)
        {
            $stocks = $stocks + $delivery->quantity;
        }

        if(count($deliveries))
        {
            $cost = $deliveries->last()->price;
        }

        $objs = (object)[
                            'quantity' => $stocks,
                            'cost'     => $cost
                        ];

        return $objs;
    }

    public function sales($inventory_id, $from, $to){
    	$cost     = 0;
    	$total_qty= 0;

        $inv = Inventory::findOrFail($inventory_id);

        $pos = POS::where('inventory_id', $inv->id)->where('supplier', 'Commissary')->first();
        
        if(count($pos))
        {
            $orders = Order::with(
                            [
                                'order_list.product_size',
                                'order_list.product.product_size.ingredients' => 
                                    function($q) use ($pos) 
                                    {
                                        $q->where('inventory_product_size.inventory_id', $pos->id);
                                    }
                            ])
                        ->whereHas('order_list.product.product_size.ingredients', 
                                    function($q) use($pos) 
                                    {
                                        $q->where('inventory_product_size.inventory_id', $pos->id);
                                    })
                        ->whereBetween(DB::raw('date(created_at)'), [$from, $to])
                        ->get();

            foreach ($orders as $order) 
            {
                $qty   = 0;
                $lists = $order->order_list;

                foreach ($lists as $list) 
                {
                    $size         = $list->product_size->size;
                    $product      = $list->product;
                    $product_size = $product->product_size->where('size', $size)->first();
                    $ingredients  = $product_size->ingredients;

                    foreach ($ingredients as $ingredient) 
                    {
                        $sold      = 0;
                        $qty       = (int)$list->quantity;
                        $qty_use   = $ingredient->pivot->quantity;
                        $price     = count($ingredient->stocks) ? $ingredient->stocks->last()->price : 0;                        
                        $sold      = (($qty * $qty_use) * $price);
                        $cost      = $price;
                        $total_qty = $total_qty + ($qty * $qty_use);
                    }
                }            
            }
        }

		return (object)['cost' => $cost, 'quantity' => $total_qty];
    }

    public function dispose($inventory_id, $from, $to){
    	$quantity = 0;
    	$cost     = 0;
    	$disposes = Dispose::where('inventory_id', $inventory_id)
    					->whereBetween('date', [$from, $to])
                        ->where('type', 'Raw Material')
    					->get();

    	foreach ($disposes as $dispose) 
    	{
    		$quantity = $quantity + $dispose->quantity;
    	}

    	if(count($disposes))
    	{
			$cost = $disposes->last()->cost;
    	}
    	

    	$obj = (object)[
    						'quantity' => $quantity,
    						'cost'	   => $cost
    				   ];

    	return $obj;
    }

    public function goods_return($inventory_id, $from, $to){
    	$quantity = 0;
    	$cost     = 0;
    	$goods    = GoodsReturn::where('inventory_id', $inventory_id)
    					->whereBetween('date', [$from, $to])
    					->get();

    	foreach ($goods as $good) 
    	{
    		$quantity = $quantity + $good->quantity;
    	}

    	if(count($goods))
    	{
    		$cost = $goods->last()->cost;
    	}

    	$objs = (object)[
    						'quantity' => $quantity,
    						'cost' 	   => $cost
    				    ];

    	return $objs;
    }

    public function actual($inventory_id, $from, $to){
    	$delivery  = $this->delivery($inventory_id, $from, $to);
    	$inventory = Inventory::with(['stocks' => function($q) use($from, $to) {
                        $q->whereBetween('received', [$from, $to]);
                    }])
                    ->where('id', $inventory_id)->first();

    	// return ($inventory->stock + (count($inventory->stocks) ? $inventory->stocks->sum('quantity') : 0));
        return $inventory->stock;
    }





    /**************************************************************************/
    /*                      COMMISSARY PRODUCT                                */
    /**************************************************************************/

     public function product_beginning($product_id, $from, $to){
        $cost     = 0;
        $quantity = 0;
        $made     = 0;

        $product  = Product::with(
                            [
                                'produced' => function($q) use($from, $to) 
                                            {
                                                $q->whereBetween('date', [$from, $to]);
                                            }
                            ])
                            ->where('id', $product_id)->first();

        foreach($product->produced as $produce)
        {
            $made = $made + $produce->quantity;
        }

        $quantity = ($product->produce + $made);

        $obj = (object)[
                        'quantity' => $quantity, 
                        'cost'     => $cost
                       ];

        return $obj;
    }

    public function product_delivery($product_id, $from, $to){
        $stocks = 0;
        $cost   = 0;

        $deliveries = Delivery::where('item_id', $product_id)
                    ->whereBetween('date', [$from, $to])
                    ->where('type', 'PRODUCT')
                    ->get();

        $product = Product::findOrFail($deliveries->first()->item_id);

        foreach($deliveries as $delivery)
        {
            $stocks = $stocks + $delivery->quantity;
        }

        if(count($product))
        {
            $cost = $product->cost;
        }
        

        $objs = (object)[
                            'quantity' => $stocks,
                            'cost'     => $cost
                        ];

        return $objs;
    }

    public function product_sales($product_id, $from, $to){
        $cost     = 0;
        $total_qty= 0;

        $cproduct = Product::findOrFail($product_id);

        $pos = POS::where('inventory_id', $product_id)->where('supplier', 'Commissary')->first();
        
        if(count($pos))
        {
            $orders = Order::with(
                            [
                                'order_list.product_size',
                                'order_list.product.product_size.ingredients' => 
                                    function($q) use ($pos) 
                                    {
                                        $q->where('inventory_product_size.inventory_id', $pos->id);
                                    }
                            ])
                        ->whereHas('order_list.product.product_size.ingredients', 
                                    function($q) use($pos) 
                                    {
                                        $q->where('inventory_product_size.inventory_id', $pos->id);
                                    })
                        ->whereBetween(DB::raw('date(created_at)'), [$from, $to])
                        ->get();

            foreach ($orders as $order) 
            {
                $qty   = 0;
                $lists = $order->order_list;

                foreach ($lists as $list) 
                {
                    $size         = $list->product_size->size;
                    $product      = $list->product;
                    $product_size = $product->product_size->where('size', $size)->first();
                    $ingredients  = $product_size->ingredients;

                    foreach ($ingredients as $ingredient) 
                    {
                        $sold      = 0;
                        $qty       = (int)$list->quantity;
                        $qty_use   = $ingredient->pivot->quantity;
                        $price     = $cproduct->price;                        
                        $sold      = (($qty * $qty_use) * $price);
                        $cost      = $price;
                        $total_qty = $total_qty + ($qty * $qty_use);
                    }
                }            
            }
        }

        return (object)['cost' => $cost, 'quantity' => $total_qty];
    }

     public function product_dispose($product_id, $from, $to){
        $quantity = 0;
        $cost     = 0;
        $disposes = Dispose::where('inventory_id', $product_id)
                        ->whereBetween('date', [$from, $to])
                        ->where('type', 'Product')
                        ->get();

        foreach ($disposes as $dispose) 
        {
            $quantity = $quantity + $dispose->quantity;
        }

        if(count($disposes))
        {
            $cost = $disposes->last()->cost;
        }
        

        $obj = (object)[
                            'quantity' => $quantity,
                            'cost'     => $cost
                       ];

        return $obj;
    }




    public function getSundays($from, $to){
        $sundays  = [];
        $index    = 0;
        $from_day = date('d', strtotime($from));
        $from_mon = date('m', strtotime($from));
        $from_yr  = date('Y', strtotime($from));

        $to_day   = date('d', strtotime($to));
        $to_mon   = date('m', strtotime($to));
        $to_yr    = date('Y', strtotime($to));

        if(($to_mon - $from_mon) == 0)
        {
            for($i = $from_day - 1; $i < $to_day; $i++)
            {
                $date = date('Y-m-d', strtotime($from.' +'.$i.' day'));
                
                if($this->isSunday($from, $date))
                {
                    $sundays[$index] = $date;
                    $index++;
                }
            }
        }
        elseif(($to_mon - $from_mon) > 0)
        {

            for($x = 0; $x <= ($to_mon - $from_mon); $x++)
            {
                $month = $from_yr.'-'.($from_mon + $x).'-'.$from_day;

                for($i = $from_day - 1; $i < $to_day; $i++)
                {
                    $date = date('Y-m-d', strtotime($month.' +'.$i.' day'));

                    if($this->isSunday($month, $date))
                    {
                        if(array_search($date, $sundays) == false)
                        {
                            $sundays[$index] = $date;
                            $index++;
                        }
                    }
                }

            }
        }

        return $sundays;
    }

    public function isSunday($mon, $val){

        for($i = 1; $i <= 6; $i++)
        {
            $sunday = date('Y-m-d', strtotime($mon.' +'.$i.' sunday'));

            if($val === $sunday)
            {
                return TRUE;
            }

        }

        return FALSE;
    }
}
