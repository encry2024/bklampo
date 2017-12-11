<?php

namespace App\Http\Controllers\Backend\Commissary\Dispose;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\Dispose\Dispose;
use App\Models\Branch\Branch;

class DisposeController extends Controller
{
    public function index(){
    	return view('backend.commissary.dispose.index');
    }

    public function create(){
    	$inventories = Inventory::orderBy('name')->get()->pluck('name', 'id');
        $products    = Product::orderBy('name')->get()->pluck('name', 'id'); 
        $branches    = Branch::orderBy('name')->get()->pluck('name', 'id');

    	return view('backend.commissary.dispose.create', compact('inventories', 'products', 'branches'));
    }

    public function store(Request $request){
    	$inventory = Inventory::findOrFail($request->inventory_id);

    	if($request->quantity <= $inventory->stock)
    	{
    		$dispose = new Dispose();
	    	$dispose->inventory_id 	= $inventory->id;
	    	$dispose->date 		   	= $request->date;
	    	$dispose->quantity		= $request->quantity;
	    	$dispose->cost 			= $inventory->stocks->last()->price;
	    	$dispose->total_cost	= $dispose->cost * $dispose->quantity;
	    	$dispose->witness 		= $request->witness;
	    	$dispose->reason 		= $request->reason;
            $dispose->branch_id     = $request->branch_id;
            $dispose->type          = $request->item_type;
	    	$dispose->save();

	    	$inventory->stock 		= $inventory->stock - $dispose->quantity;
	    	$inventory->save();

	    	return redirect()->route('admin.commissary.dispose.index')->withFlashSuccess('Item has been disposed!');
    	}
    	
    	return redirect()->back()->withFlashDanger('Dispose quantity is greater than stocks');
    }

    public function destroy(Dispose $dispose){
    	$inventory = Inventory::findOrFail($dispose->inventory_id);
    	$inventory->stock = $inventory->stock + $dispose->quantity;
    	$inventory->save();

    	$dispose->delete();

    	return redirect()->route('admin.commissary.dispose.index')->withFlashDanger('Record has been deleted!');
    }
}
