<?php

namespace App\Http\Controllers\Backend\Report\Commissary\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\OrderList\OrderList;
use App\Models\ProductSize\ProductSize;
use App\Models\Category\Category;
use App\Models\Commissary\Product\Product as CommissaryProduct;
use App\Models\Inventory\Inventory;
use App\Models\Branch\Branch;
use DB;

class ReportController extends Controller
{
    public function index(){
        $to      = date('Y-m-d', strtotime('sunday'));
        $from    = date('Y-m-d', strtotime($to.' -6 day'));
        $reports = $this->get_inventory($from, $to);

    	return view('backend.report.commissary.sale.daily.index', compact('reports', 'from', 'to'));
    }

    public function store(Request $request){
        $from    = date('Y-m-d', strtotime($request->from));
        $to      = date('Y-m-d', strtotime($request->to));
        $reports = $this->get_inventory($from, $to);   
        
        return view('backend.report.commissary.sale.daily.index', compact('reports' ,'from', 'to'));
    }

    public function getItem($reports, $category, $branch, $ingredient)
    {
        $days = (object)['mon' => 0, 'tue' => 0, 'wed' => 0, 'thu' => 0, 'total' => 0];

        if(count($reports[$category]))
        {
            $category = $reports[$category];

            if(count($category->branches[$branch]))
            {
                $branch = $category->branches[$branch];

                if(count($branch))
                {
                    if(count($branch->items))
                    {
                        $item  = $branch->items[$ingredient];
                        for($i = 0; $i < count($item->days); $i++)
                        {
                            $days->mon += $item->days[$i]['mon'];
                            $days->tue += $item->days[$i]['tue'];
                            $days->wed += $item->days[$i]['wed'];
                            $days->thu += $item->days[$i]['thu'];
                        }
                    }
                    
                } 
            }
        }
        
        $days->total = $days->mon + $days->tue + $days->wed + $days->thu;
        
        return $days;                                
    }

    public function get_inventory($from, $to){
        $index   = 0;
        $reports = [];

        foreach (Category::all() as $category) 
        {
            $index2      = 0;
            $branches    = [];
            $inventories = Inventory::where('category_id', $category->id)->where('supplier', 'Commissary Raw Material')->get();

            foreach (Branch::all() as $branch) 
            {
                $index       = 0;
                $objects     = [];

                foreach ($inventories as $inventory) 
                {
                    $objects[$index] = (object)[
                                            'name' => $inventory->commissary_inventory->name,
                                            'days' => $this->filterReport($branch->id, $inventory->id, $from, $to)
                                        ];

                    $index++;
                }

                $branches[$index2] = (object)['name'  => $branch->name, 'items' => $objects];
                $index2++;
            }
            

            $reports[strtolower($category->name)] = (object)[
                                                        'category' => $category->name,
                                                        'branches' => $branches
                                                    ];
        }

        return $reports;
    }

    public function filterReport($branch_id, $inventory_id, $from, $to){
        $sundays    = $this->getSundays($from, $to);
        $weekdays   = ['mon', 'tue', 'wed', 'thu'];
        $objects    = [];
        $sunday_days= [];
        $index      = 0;

        foreach($sundays as $sunday)
        {
            for($i = 6; $i > 2; $i--)
            {
                $days[$i] = date('Y-m-d', strtotime($sunday.' -'.$i.' day'));
            }
            //
            // arrange date index
            //
            $temp    = $days;
            $days[0] = $temp[6];
            $days[1] = $temp[5];
            $days[2] = $temp[4];
            $days[3] = $temp[3];
            $days    = array_splice($days, 0, 4);


            for($i = 0; $i < count($days); $i++)
            {

                $sales      = 0;
                $orders     = Order::with(
                                [
                                    'order_list.product_size',
                                    'order_list.product.product_size.ingredients' => function($q) use ($inventory_id) {
                                        $q->where('inventory_product_size.inventory_id', $inventory_id);
                                    }
                                ])
                            ->whereHas('order_list.product.product_size.ingredients', function($q) use($inventory_id) {
                                $q->where('inventory_product_size.inventory_id', $inventory_id);
                            })
                            ->whereRaw('date(created_at) = "'.$days[$i].'"')
                            ->where('branch_id', $branch_id)
                            ->get();

                foreach ($orders as $order) {
                    $qty   = 0;
                    $lists = $order->order_list;

                    foreach ($lists as $list) {
                        $size         = $list->product_size->size;
                        $product      = $list->product;
                        $product_size = $product->product_size->where('size', $size)->first();
                        $ingredients  = $product_size->ingredients;

                        foreach ($ingredients as $ingredient) {
                            $sold    = 0;
                            $price   = 0;
                            $qty     = (int)$list->quantity;
                            $qty_use = $ingredient->pivot->quantity;

                            if(count($ingredient->stocks))
                            {
                                $price = $ingredient->stocks->last()->price;
                            }           

                            $sold    = (($qty * $qty_use) * $price);
                            $sales   = $sold;
                        }
                        
                    }            
                }

                $objects[$weekdays[$i]] = $sales;
            }

            $sunday_days[$index] = $objects;
            $index++;
        }        

        return $sunday_days;
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
            $month = $from_yr.'-'.$from_mon.'-'.$from_day;

            for($i = 0; $i < 7; $i++)
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
