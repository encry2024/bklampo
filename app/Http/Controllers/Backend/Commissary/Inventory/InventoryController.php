<?php

namespace App\Http\Controllers\Backend\Commissary\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Models\Commissary\Inventory\Inventory;

use App\Http\Requests\Backend\Inventory\StoreInventoryRequest;

class InventoryController extends Controller
{
    public function index(){
    	return view('backend.commissary.inventory.index');
    }

    public function create(){
    	$categories = Category::pluck('name', 'id');

    	return view('backend.commissary.inventory.create', compact('categories'));
    }

    public function store(StoreInventoryRequest $request){
    	Inventory::updateOrCreate(
    		['name' => $request->name],
    		[
                'unit_type'     => $request->unit_type,
    			'reorder_level' => $request->reorder_level,
    			'category_id'	=> $request->category_id
    		]
    	);

    	return redirect()->route('admin.commissary.inventory.index');
    }

    public function edit(Inventory $inventory){
    	$categories = Category::pluck('name', 'id');

    	return view('backend.commissary.inventory.edit', compact('categories', 'inventory'));
    }

    public function update(Inventory $Inventory, Request $request){
    	$Inventory->update([
    		'name' 			=> $request->name,
            'unit_type'     => $request->unit_type,
    		'reorder_level' => $request->reorder_level,
            'category_id'   => $request->category_id
    	]);

    	return redirect()->route('admin.commissary.inventory.index')->withFlashSuccess('Inventory Updated Successfully!');
    }

    public function destroy(Inventory $Inventory){
    	$Inventory->delete();

    	return redirect()->route('admin.commissary.inventory.index')->withFlashDanger('Inventory Deleted Successfully!');
    }
}
