<?php

namespace App\Http\Controllers\Backend\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Inventory\Inventory;
use App\Models\Stock\Stock;
use App\Models\Product\Product;
use App\Models\ProductSize\ProductSize;
use App\Models\Commissary\Delivery\Delivery;
use App\Models\Commissary\History\History;

use App\Http\Requests\Backend\Stock\ManageRequest;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    
	public function index(){
		return view('backend.stock.index');
	}

	public function create(){
		$inventories = Inventory::all();
        $ingredients = [];
        $selections  = [];

        foreach($inventories as $inventory)
        {
            $name = '';
            $temp = [];

            if($inventory->supplier == 'Other')
            {
                $name = $inventory->other->name;
            }
            elseif($inventory->supplier == 'Commissary Product')
            {
                $name = $inventory->commissary_product->name;
            }
            else
            {
            	$name = $inventory->commissary_inventory->name;
            }

            $selections[$inventory->id] = $name;
            $temp = ['id' => $inventory->id, 'name' => $name];

            array_push($ingredients, $temp);
        }

        $inventories = (object)$selections;
		
		return view('backend.stock.create', compact('inventories'));
	}

	public function store(ManageRequest $request){
		$inventory 	= Inventory::find($request->inventory_id);

		$product_sizes = ProductSize::with(['ingredients' => function($q) use($inventory) {
				$q->where('inventory_product_size.inventory_id', $inventory->id);
			 } ])->get();

		
		// check if ingredient is from commissary
		
		

		if($inventory->supplier == 'Commissary Product')
		{
			$flag       = 0;
			$deliveries = Delivery::where('item_id', $inventory->inventory_id)
						->where('status', 'NOT RECEIVED')
						->where('type', 'PRODUCT')
						->where('branch_id', Auth::user()->branch->id)
						->get();

			if(!count($deliveries))
			{
				return redirect()->route('admin.stock.create')->withFlashDanger('Request quantity does not match from delivered quantity!');
			}

			foreach($deliveries as $delivery)
			{
				if($delivery->quantity >= $request->quantity)
				{
					$delivery->status = 'RECEIVED';
					$delivery->save();

					$history 				= new History();
					$history->product_id 	= $delivery->item_id;
					$history->description 	= Auth::user()->branch->name.' received '.$request->quantity.' '.$delivery->product->name;
					$history->status 		= 'Minus';
					$history->save();

					$flag = 1;
				}

				if($flag)
					break;
			}
			
			if(!$flag)
			{
				return redirect()->route('admin.stock.create')->withFlashDanger('Request quantity does not match from delivered quantity!');
			}
		}
		elseif($inventory->supplier == 'Commissary Raw Material')
		{
			$flag       = 0;
			$deliveries = Delivery::where('item_id', $inventory->inventory_id)
						->where('status', 'NOT RECEIVED')
						->where('type', 'RAW MATERIAL')
						->where('branch_id', Auth::user()->branch->id)
						->get();

			if(!count($deliveries))
			{
				return redirect()->route('admin.stock.create')->withFlashDanger('Request quantity does not match from delivered quantity!');
			}

			foreach($deliveries as $delivery)
			{
				if($delivery->quantity >= $request->quantity)
				{
					$delivery->status = 'RECEIVED';
					$delivery->save();

					$flag = 1;
				}

				if($flag)
					break;
			}

			if(!$flag)
			{
				return redirect()->route('admin.stock.create')->withFlashDanger('Request quantity does not match from delivered quantity!');
			}
			
		}

		Stock::create($request->all());
		
		$inventory->AddStock($request->quantity);
		$inventory->save();

		//
		// update all product cost
		//


		return redirect()->route('admin.stock.index')->withFlashSuccess('Stock Added Successfully!');
	}

	public function edit(Stock $stock){
		$inventory = $stock->inventory;
		$name      = '';

		if($inventory->supplier == 'Commissary Product')
		{
			$name = $inventory->commissary_product->name;
		}
		elseif($inventory->supplier == 'Commissary Raw Material')
		{
			$name = $inventory->commissary_inventory->name;
		}
		else
		{
			$name = $inventory->other->name;
		}

		return view('backend.stock.edit', compact('name', 'stock'));
	}

	public function update(Stock $stock, ManageRequest $request){
		$stock->inventory_id	= $request->inventory_id;
		$stock->quantity		= $request->quantity;
		$stock->price			= $request->price;
		$stock->received		= $request->received;
		$stock->expiration		= $request->expiration;
		$stock->status			= $request->status.($request->status == 'EXPIRE' ? 'D' :'ED');
		$stock->save();

		$stock = Stock::selectRaw('sum(quantity) as "quantity"')
				->where('inventory_id', $request->inventory_id)
				->where('status', 'fresh')
				->first();

		$inventory = Inventory::find($request->inventory_id);
		$inventory->stock = $inventory->stock - (count($stock->quantity) > 0 ? $stock->quantity:0);
		$inventory->save();

		return redirect()->route('admin.stock.index')->withFlashSuccess('Stock Updated Successfully!');
	}

	public function destroy(Stock $stock){
		$inventory = $stock->inventory;
		
		if($inventory->supplier == 'Commissary Raw Material')
		{
			$delivery = Delivery::where('item_id', $inventory->commissary_product->id)->first();
			$delivery->status = 'NOT RECEIVED';
			$delivery->save();
		}
		elseif($inventory->supplier == 'Commissary Product')
		{
			$delivery = Delivery::where('item_id', $inventory->commissary_inventory->id)->first();
			$delivery->status = 'NOT RECEIVED';
			$delivery->save();
		}

		$inventory->stock = $inventory->stock - $stock->quantity;
		$inventory->save();

		$stock->delete();

		return redirect()->route('admin.stock.index')->withFlashDanger('Stock has Been Deleted Successfully!');
	}

	public function updateProductCost(){
		$products = Product::all();

		foreach ($products as $product) {
			$product_cost  = 0;
			$inventories   = $product->inventories;

			if(count($inventories))
			{
				foreach ($inventories as $inventory) {
					$stock = $inventory->stocks->last();

					if(count($stock)){
						$product_cost += $stock->price;
					}
				}
			}

			$product->cost = $product_cost;
			$product->save();
		}
	}

}
