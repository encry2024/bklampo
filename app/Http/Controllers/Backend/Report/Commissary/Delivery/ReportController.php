<?php

namespace App\Http\Controllers\Backend\Report\Commissary\Delivery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Delivery\Delivery;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Stock\Stock;
use App\Models\Category\Category;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(){
        $to      = date('Y-m-d', strtotime('sunday'));
        $from    = date('Y-m-d', strtotime($to.' -6 day'));

        $reports = $this->get_report($from, $to);    	
// return $reports;
    	return view('backend.report.commissary.delivery.index', compact('reports', 'from', 'to'));
    }

    public function store(Request $request){
        $from    = date('Y-m-d', strtotime($request->from));
        $to      = date('Y-m-d', strtotime($request->to));

        $reports = $this->get_report($from, $to);

        return view('backend.report.commissary.delivery.index', compact('reports','from', 'to'));
    }

    public function get_report($from, $to){
        $index   = 0;
        $reports = [];

        foreach (Category::all() as $category) {
            $objects        = [];
            $inventories    = Inventory::where('category_id', $category->id)->get();
            
            foreach ($inventories as $inventory) {
                $objects[$index] = (object)[
                                        'name' => $inventory->name,
                                        'unit' => $inventory->unit_type,
                                        'days' => $this->filterReport($inventory->id, $from, $to)
                                    ];

                $index++;

            }

            $reports[strtolower($category->name)] = (object)[
                                    'category'  => $category->name,
                                    'items'     => $objects
                                ];
        }

        $index    = 0;
        $products = Product::all();

        foreach($products as $product)
        {
            $objects[$index] = (object)[
                                        'name' => $product->name,
                                        'unit' => '',
                                        'days' => $this->filterReportProduct($product->id, $from, $to)
                                    ];

            $index++;
        }

        $reports['product'] = (object)[
                                    'category'  => 'Product',
                                    'items'     => $objects
                                ];

        return $reports;
    }

    public function filterReport($inventory_id, $from, $to){
        $weekdays    = ['sun', 'sat', 'fri', 'thurs', 'wed', 'tue', 'mon'];
        $sundays     = $this->getSundays($from, $to);
        $sundays_days= [];
        $index       = 0;

        foreach($sundays as $sunday)
        {
            $days  = [];
            $datas = [];

            for($i = 0; $i < 7; $i++)
            {
                $days[$i] = date('Y-m-d', strtotime($sunday.' -'.$i.' day'));
            }

            for($i = 0; $i < count($days); $i++)
            {
                $delivered = Delivery::where('item_id', $inventory_id)
                            ->where('date', $days[$i])
                            ->where('type', 'RAW MATERIAL')
                            ->get();

                $datas[$weekdays[$i]] = $delivered;
            }

            $sundays_days[$index] = $datas;
            $index++;
        }

        $sundays_days = (object)$sundays_days;

        return $sundays_days;
    }

    public function filterReportProduct($inventory_id, $from, $to){
        $weekdays    = ['sun', 'sat', 'fri', 'thurs', 'wed', 'tue', 'mon'];
        $sundays     = $this->getSundays($from, $to);
        $sundays_days= [];
        $index       = 0;

        foreach($sundays as $sunday)
        {
            $days  = [];
            $datas = [];

            for($i = 0; $i < 7; $i++)
            {
                $days[$i] = date('Y-m-d', strtotime($sunday.' -'.$i.' day'));
            }

            for($i = 0; $i < count($days); $i++)
            {
                $delivered = Delivery::where('item_id', $inventory_id)
                            ->where('date', $days[$i])
                            ->where('type', 'PRODUCT')
                            ->get();

                $datas[$weekdays[$i]] = $delivered;
            }

            $sundays_days[$index] = $datas;
            $index++;
        }

        $sundays_days = (object)$sundays_days;

        return $sundays_days;
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
