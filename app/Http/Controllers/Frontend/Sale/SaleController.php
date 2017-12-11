<?php

namespace App\Http\Controllers\Frontend\Sale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Order\Order;
use App\Models\OrderList\OrderList;
use App\Models\Inventory\Inventory;
use App\Models\ProductSize\ProductSize;
use App\Models\Notification\Notification;
use Auth;
use DB;

class SaleController extends Controller
{
    public function index(){
        $total  = 0;
        $orders = Order::where(Db::raw('date(created_at)'), date('Y-m-d'))
                  ->where('user_id', Auth::user()->id)
                  ->orderBy('created_at', 'desc')
                  ->get();

        foreach ($orders as $order) {
            $total = $total + $order->payable;
        }

        return view('frontend.user.sale.daily', compact('total', 'orders'));
    }

    public function monthly(){
        $total  = 0;
        $date   = date('F Y');
        $orders = Order::whereBetween(Db::raw('date(created_at)'), [date('Y-m-01'), date('Y-m-31')])
                  ->where('user_id', Auth::user()->id)
                  ->orderBy('created_at', 'desc')
                  ->get();

        foreach ($orders as $order) {
            $total = $total + $order->payable;
        }

        return view('frontend.user.sale.monthly', compact('total', 'orders', 'date'));
    }

    public function save(Request $request){
    	$arr 	= json_decode($request->orders);

    	$order 	= new Order();
    	$order->transaction_no  = date('y-m').rand(100000, 999999);
        $order->cash            = $request->cash;
        $order->change          = $request->change;
        $order->payable         = $request->payable;
        $order->user_id         = Auth::user()->id;
        $order->branch_id       = Auth::user()->branch_id;
    	$order->save();
        //
        // set stock use
        //
    	for($i = 0; $i < count($arr); $i++){
            $size = ProductSize::where('size', $arr[$i]->size)->first();

    		$list = new OrderList();
    		$list->order()->associate($order);
    		$list->product_id         = $arr[$i]->id;
    		$list->price 		      = $arr[$i]->price;
    		$list->quantity           = $arr[$i]->qty;
    		$list->product_size_id    = $size->id;
    		$list->save();

            $product      = Product::findOrFail($list->product_id);
            $product_size = $product->product_size;

            foreach ($product_size as $size) {
                $inventories = $size->ingredients;

                foreach($inventories as $inventory){
                    $pivot = $inventory->pivot;

                    $inventory->stock = $inventory->stock - ($pivot->quantity * $list->quantity);
                    $inventory->save();
                }
            } 
    	}

        $this->notification();

    	return ['success', $order->transaction_no];
    }

    public function notification(){
        $inventories = Inventory::whereRaw('stock < reorder_level')->get();

        foreach ($inventories as $inventory) {
            $desc = $inventory->name.' has '.$inventory->stock.' stocks left.';

            Notification::updateOrCreate(
                [
                    'date' => date('Y-m-d'), 
                    'description' => $desc,
                    'status' => 'new'
                ],
                [
                    'inventory_id' => $inventory->id
                ]
            ); 
        }

        // return $inventories;
    }
}
