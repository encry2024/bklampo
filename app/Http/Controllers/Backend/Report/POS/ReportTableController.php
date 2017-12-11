<?php

namespace App\Http\Controllers\Backend\Report\POS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Report\ReportRepository;
use App\Models\Order\Order;

class ReportTableController extends Controller
{
    protected $reports;

    public function __construct(ReportRepository $reports){
    	$this->reports = $reports;
    }

    public function __invoke(Request $request){
        // return $datatable->html();
    	return Datatables::of($this->reports->getForDataTable())
    		->escapeColumns(['id', 'sort'])
    		->addColumn('quality_size', function($order) {
    			$lists  = $order->order_list;
    			$size_sm= 0;
                $size_md= 0;
    			$size_lg= 0;
    			$size   = '';

    			foreach ($lists as $list) {
                    $product = $list->product_size;

    				if($product->size == 'Small')
    					$size_sm += $list->quantity;
                    elseif($product->size == 'Medium')
                        $size_md += $list->quantity;
    				else
    					$size_lg += $list->quantity;
    			}

    			if($size_sm > 0){
    				$size = $size_sm.' Small';
    			}

                if($size_md > 0){
                    $size .= $size_sm > 0 ? ' / ': '';
                    $size .= $size_md.' Medium';
                }

    			if($size_lg > 0){
    				$size .= $size_md > 0 ? ' / ': '';
    				$size .= $size_lg.' Large';
    			}
    			
    			return $size;
    		})
    		->addColumn('total', function($order){
				$lists  = $order->order_list;
    			$total  = $lists->sum('price');

    			return number_format($total, 2);
    		})
    		->addColumn('actions', function($order) {
    			return $order->action_buttons;
    		})
    		->make();
    }
}
