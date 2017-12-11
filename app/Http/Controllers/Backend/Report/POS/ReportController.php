<?php

namespace App\Http\Controllers\Backend\Report\POS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\OrderList\OrderList;
use App\Repositories\Backend\Report\ReportRepository;

class ReportController extends Controller
{
    public function index(){
    	return view('backend.report.pos.sale.index');
    }

    public function show($id){
    	$order = Order::findOrFail($id);

    	return view('backend.report.pos.sale.show', compact('order'));
    }

    public function destroy($id){
    	$order = Order::findOrFail($id);

    	foreach ($order->order_list as $list) {
    		$list->delete();
    	}

    	$order->delete();

    	return redirect()->route('admin.report.pos.sale.index');
    }
}
