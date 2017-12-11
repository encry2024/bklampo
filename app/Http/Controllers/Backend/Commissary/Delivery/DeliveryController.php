<?php

namespace App\Http\Controllers\Backend\Commissary\Delivery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\Delivery\Delivery;
use App\Models\Branch\Branch;


class DeliveryController extends Controller
{
	public function index(){
		return view('backend.commissary.delivery.index');
	}

	public function create(){
		$inventories = Inventory::orderBy('name')->get()->pluck('name', 'id');
		$products  	 = Product::orderBy('name')->get()->pluck('name', 'id');
        $branches 	 = Branch::orderBy('name')->get()->pluck('name', 'id');
		// return $unions;
		return view('backend.commissary.delivery.create', compact('products', 'inventories', 'branches'));
	}

	public function store(Request $request){

		if($request->item_type == 'Product')
		{
			$product = Product::findOrFail($request->item_id);

			if($product->produce >= $request->quantity)
			{
				$delivery = new Delivery();
				$delivery->item_id   = $request->item_id;
				$delivery->branch_id = $request->branch_id;
				$delivery->quantity  = $request->quantity;
				$delivery->date 	 = $request->date;
				$delivery->price 	 = $product->price;
				$delivery->type      = $request->item_type;
				$delivery->save();

				$product->produce = $product->produce - $request->quantity;
				$product->save();
			}
		}
		else
		{
			$inventory = Inventory::findOrFail($request->item_id);

			if($inventory->stock >= $request->quantity)
			{
				$delivery = new Delivery();
				$delivery->item_id   = $request->item_id;
				$delivery->branch_id = $request->branch_id;
				$delivery->quantity  = $request->quantity;
				$delivery->date 	 = $request->date;
				$delivery->price 	 = count($inventory->stocks) ? $inventory->stocks->last()->price : 0;
				$delivery->type      = $request->item_type;
				$delivery->save();

				$inventory->stock = $inventory->stock - $request->quantity;
				$inventory->save();
			}
		}

		return redirect()->route('admin.commissary.delivery.index')->withFlashSuccess('Item has been recorded!');
	}
}
