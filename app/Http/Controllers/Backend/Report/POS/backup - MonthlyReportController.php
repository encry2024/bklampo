<?php

namespace App\Http\Controllers\Backend\Report\POS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\OrderList\OrderList;
use App\Models\Product\Product;
use Carbon\Carbon;
use DB;


class MonthlyReportController extends Controller
{

    public $times = [
            '07:00 AM - 07:30 AM',
            '07:31 AM - 08:00 AM',
            '08:01 AM - 08:30 AM',
            '08:31 AM - 09:00 AM',
            '09:01 AM - 09:30 AM',
            '09:31 AM - 10:00 AM',
            '10:01 AM - 10:30 AM',
            '10:31 AM - 11:00 AM',
            '11:01 AM - 11:30 AM',
            '11:31 AM - 12:00 PM',
            '12:01 PM - 12:30 PM',
            '12:31 PM - 01:00 PM',
            '01:01 PM - 01:30 PM',
            '01:31 PM - 02:00 PM',
            '02:01 PM - 02:30 PM',
            '02:31 PM - 03:00 PM',
            '03:01 PM - 03:30 PM',
            '03:31 PM - 04:00 PM',
            '04:01 PM - 04:30 PM',
            '04:31 PM - 05:00 PM',
            '05:01 PM - 05:30 PM',
            '05:31 PM - 06:00 PM',
            '06:01 PM - 06:30 PM',
            '06:31 PM - 07:00 PM'
        ];


    public function index(){

        $from = date('Y-m-01');
        $to   = date('Y-m-31');

        $relations = $this->fetchReport($from, $to);
        
    	return view('backend.report.pos.monthly.index', $relations);
    }

    public function store(Request $request){
        $from = date('Y-m-01', strtotime(new Carbon($request->date)));
        $to   = date('Y-m-31', strtotime(new Carbon($request->date)));
        
        $relations = $this->fetchReport($from, $to);

    	return view('backend.report.pos.monthly.index', $relations);
    }


    public function fetchReport($from, $to){      //
        // juice
        //
        $juices         = $this->soldJuice('JUICE', $from, $to);
        $lychee_juices  = $this->soldJuice('LYCHEE JUICE', $from, $to);
        //
        // shakes
        //
        $banana         = $this->soldShake('Banana Shake', $from, $to);
        $buko           = $this->soldShake('Buko Shake', $from, $to);
        $carrot         = $this->soldShake('Carrot Shake', $from, $to);
        $corn           = $this->soldShake('Corn Shake', $from, $to);
        $cucumber       = $this->soldShake('Cucumber Shake', $from, $to);
        $manggo_green   = $this->soldShake('Green Manggo Shake', $from, $to);
        $lychee         = $this->soldShake('Lychee Shake', $from, $to);
        $manggo         = $this->soldShake('Manggo Shake', $from, $to);
        $melon          = $this->soldShake('Melon Shake', $from, $to);
        $pandan         = $this->soldShake('Pandan Shake', $from, $to);
        $avocado        = $this->soldShake('Avocado Shake', $from, $to);
        $strawberry     = $this->soldShake('Strawberry Shake', $from, $to);
        //
        // dessert
        //
        $halo2x         = $this->soldDessert('BB Halo2x', $from, $to);
        $buko_corn      = $this->soldDessert('Buko Corn', $from, $to);
        $buko_lyc       = $this->soldDessert('Buko Lyc', $from, $to);
        $buko_pdn       = $this->soldDessert('Buko Pdn', $from, $to);
        //
        // extras
        //
        $milk           = $this->soldExtras('Milk', $from, $to);
        $syrup          = $this->soldExtras('Syrup', $from, $to);
        $buko_meat      = $this->soldExtras('Buko Meat', $from, $to);
        $fruit          = $this->soldExtras('Fruit', $from, $to);
        $premium_fruit  = $this->soldExtras('Premium Fruit', $from, $to);


        $relations = [
            'times'         => $this->times,
            'juices'        => $juices,
            'lychee_juices' => $lychee_juices,
            'banana'        => $banana,
            'buko'          => $buko,
            'carrot'        => $carrot,
            'corn'          => $carrot,
            'cucumber'      => $cucumber,
            'manggo_green'  => $manggo_green,
            'lychee'        => $lychee,
            'manggo'        => $manggo,
            'melon'         => $melon,
            'pandan'        => $pandan,
            'avocado'       => $avocado,
            'strawberry'    => $strawberry,
            'halo2x'        => $halo2x,
            'buko_corn'     => $buko_corn,
            'buko_lyc'      => $buko_lyc,
            'buko_pdn'      => $buko_pdn,
            'milk'          => $milk,
            'syrup'         => $syrup,
            'buko_meat'     => $buko_meat,
            'fruit'         => $fruit,
            'premium_fruit' => $premium_fruit,
            'filter_date'   => date('F Y', strtotime($from))
        ];

        return $relations;
    }// count sold juice
    //
    public function soldJuice($category, $from_date, $to_date) {
    	$consume_times 	= [];

    	for($i = 0; $i < count($this->times); $i++)
    	{
	    	$juice_md 		= 0;
	    	$juice_lg 		= 0;
    		$index 			= strpos($this->times[$i], '-');
	    	$from  			= date('H:i', strtotime(substr($this->times[$i], 0, $index)) );
	    	$to    			= date('H:i', strtotime(substr($this->times[$i], ($index + 1))));

	    	$products_juice = Product::with(['order_list' => function($q) use($from, $to, $from_date, $to_date) {
	    		$q->whereRaw('time(created_at) between "'.$from.'" and "'.$to.'"')
	    		  ->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"');
	    	}])
	    	->whereHas('order_list', function($q) use($from, $to, $from_date, $to_date) {
	    		$q->whereRaw('time(created_at) between "'.$from.'" and "'.$to.'"')
	    		  ->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"');
	    	})
	    	->where('category', $category)->get();

	    	foreach ($products_juice as $products) {
	    		foreach ($products->order_list as $product) {
	    			if($product->size == 'Medium')
	    			{
	    				$juice_md += $product->quantity;
	    			}

	    			if($product->size == 'Large')
	    			{
	    				$juice_lg += $product->quantity;
	    			}
	    		} //end foreach
	    	}//end foreach

	    	$consume 			= (object)['time' => $this->times[$i], 'size' => (object)['medium' => $juice_md, 'large' => $juice_lg]];
	    	$consume_times[$i] 	= $consume;
    	}//end for loop

    	return $consume_times;
    }


    //
    // count sold shake
    //
    public function soldShake($product_name, $from_date, $to_date) {
    	$consume_times 	= [];

    	for($i = 0; $i < count($this->times); $i++)
    	{
	    	$count 			= 0;
    		$index 			= strpos($this->times[$i], '-');
	    	$from  			= date('H:i', strtotime(substr($this->times[$i], 0, $index)) );
	    	$to    			= date('H:i', strtotime(substr($this->times[$i], ($index + 1))));

	    	$products_juice =  Product::with(['order_list' => function($q) use($from, $to, $from_date, $to_date) {
                                $q->whereRaw('date(created_at) between "'.$from_date.' " and "'.$to_date.'"')
                                  ->whereRaw('time(created_at) between "'.$from.' " and "'.$to.'"');
                            }])
                            ->whereHas('order_list', function($q) use($from, $to, $from_date, $to_date) {
                                $q->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"')
                                  ->whereRaw('time(created_at) between "'.$from.' " and "'.$to.'"');
                            })
                            ->where('category', 'SHAKES')
                            ->where('name', $product_name)
                            ->get();

	    	foreach ($products_juice as $products) {
	    		foreach ($products->order_list as $product) {
	    			$count += $product->quantity;
	    		} //end foreach
	    	}//end foreach

	    	$consume 			= (object)['time' => $this->times[$i], 'count' => $count];
	    	$consume_times[$i] 	= $consume;
    	}//end for loop

    	return $consume_times;
    }

    //
    // count sold shake
    //
    public function soldDessert($product_name, $from_date, $to_date) {
    	$consume_times 	= [];

    	for($i = 0; $i < count($this->times); $i++)
    	{
	    	$count 			= 0;
    		$index 			= strpos($this->times[$i], '-');
	    	$from  			= date('H:i', strtotime(substr($this->times[$i], 0, $index)) );
	    	$to    			= date('H:i', strtotime(substr($this->times[$i], ($index + 1))));

	    	$products_juice = Product::with(['order_list' => function($q) use($from, $to, $from_date, $to_date) {
	    		$q->whereRaw('time(created_at) between "'.$from.'" and "'.$to.'"')
	    		  ->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"');
	    	}])
	    	->whereHas('order_list', function($q) use($from, $to, $from_date, $to_date) {
	    		$q->whereRaw('time(created_at) between "'.$from.'" and "'.$to.'"')
	    		  ->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"');
	    	})
	    	->where('category', 'DESSERTS')
	    	->where('name', $product_name)->get();

	    	foreach ($products_juice as $products) {
	    		foreach ($products->order_list as $product) {
	    			$count += $product->quantity;
	    		} //end foreach
	    	}//end foreach

	    	$consume 			= (object)['time' => $this->times[$i], 'count' => $count];
	    	$consume_times[$i] 	= $consume;
    	}//end for loop

    	return $consume_times;
    }

    //
    // count sold shake
    //
    public function soldExtras($product_name, $from_date, $to_date) {
    	$consume_times 	= [];

    	for($i = 0; $i < count($this->times); $i++)
    	{
	    	$count 			= 0;
    		$index 			= strpos($this->times[$i], '-');
	    	$from  			= date('H:i', strtotime(substr($this->times[$i], 0, $index)) );
	    	$to    			= date('H:i', strtotime(substr($this->times[$i], ($index + 1))));

	    	$products_juice = Product::with(['order_list' => function($q) use($from, $to, $from_date, $to_date) {
	    		$q->whereRaw('time(created_at) between "'.$from.'" and "'.$to.'"')
	    		  ->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"');
	    	}])
	    	->whereHas('order_list', function($q) use($from, $to, $from_date, $to_date) {
	    		$q->whereRaw('time(created_at) between "'.$from.'" and "'.$to.'"')
	    		  ->whereRaw('date(created_at) between "'.$from_date.'" and "'.$to_date.'"');
	    	})
	    	->where('category', 'EXTRAS')
	    	->where('name', $product_name)->get();

	    	foreach ($products_juice as $products) {
	    		foreach ($products->order_list as $product) {
	    			$count += $product->quantity;
	    		} //end foreach
	    	}//end foreach

	    	$consume 			= (object)['time' => $this->times[$i], 'count' => $count];
	    	$consume_times[$i] 	= $consume;
    	}//end for loop

    	return $consume_times;
    }
}
