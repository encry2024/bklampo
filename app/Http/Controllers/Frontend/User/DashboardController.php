<?php

namespace App\Http\Controllers\Frontend\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product\Product;
use App\Models\Inventory\Inventory;
use App\Models\Notification\Notification;
use App\Models\Request\RequestMessage;
use App\Models\Response\ResponseMessage;
use Auth;
/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
    	$products = Product::all();

        // return Product::with('product_size','product_size.ingredients')->first();

        return view('frontend.user.dashboard', compact('products'));
    }

    public function get($id){
        $product = Product::with('product_size','product_size.ingredients.commissary_product', 'product_size.ingredients.other','product_size.ingredients.commissary_inventory')
            ->where('id', $id)
            ->first();
            
        return $product;
    }

    public function request(Request $request){
        $req_msg            = new RequestMessage();
        $req_msg->date      = date('Y-m-d');
        $req_msg->title     = $request->title;
        $req_msg->message   = $request->message;
        $req_msg->quantity  = $request->quantity;
        $req_msg->unit_type = $request->unit_type;
        $req_msg->user_id   = Auth::user()->id;
        $req_msg->save();

        return 'success';
    }

    public function getAllRequest(){
        $request = RequestMessage::with('response')->orderBy('id', 'desc')->take(50)->get();

        return $request;
    }

    public function getResponse($id) {
        return ResponseMessage::findOrFail($id);
    }
}
