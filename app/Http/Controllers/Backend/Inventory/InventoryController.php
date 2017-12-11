<?php

namespace App\Http\Controllers\Backend\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Inventory;
use App\Models\Category\Category;
use App\Models\Commissary\Product\Product as CommissaryProduct;
use App\Models\Commissary\Inventory\Inventory as CommissaryInventory;
use App\Models\Other\Inventory as OtherInventory;
use App\Http\Requests\Backend\Inventory\StoreInventoryRequest;
use App\Repositories\Backend\Inventory\InventoryRepository;

use Carbon\Carbon;

class InventoryController extends Controller
{

    public function index(){
    	return view('backend.Inventory.index');
    }

    public function create(){
        $categories  = Category::pluck('name', 'id');

        $inventories = Inventory::where('supplier', 'Commissary Product')->get()->pluck('inventory_id');

        $products    = CommissaryProduct::whereNotIn('id', $inventories)->pluck('name', 'id');

        $inventories = Inventory::where('supplier', 'Commissary Raw Material')->get()->pluck('inventory_id');

        $raws        = CommissaryInventory::whereNotIn('id', $inventories)->pluck('name', 'id');

    	return view('backend.Inventory.create', compact('categories', 'products', 'raws'));
    }

    public function store(StoreInventoryRequest $request){
        $others = '';

        if($request->supplier == 'Other')
        {
            $others = OtherInventory::updateOrCreate(['name' => $request->inventory_id]);
            $request['inventory_id'] = $others->id;
        }

    	Inventory::create($request->all());

    	return redirect()->route('admin.inventory.index')->withFlashSuccess('Inventory Added Successfully!');
    }

    public function edit(Inventory $inventory){
        $categories = Category::pluck('name', 'id');
        $name = '';

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

        
    	return view('backend.Inventory.edit', compact('name', 'inventory', 'categories'));
    }

    public function update(Inventory $inventory, StoreInventoryRequest $request){
    	$inventory->update($request->all());

    	return redirect()->route('admin.inventory.index')->withFlashSuccess('Inventory Updated Successfully!');
    }

    public function destroy(Inventory $inventory){
    	$inventory->delete();

    	return redirect()->route('admin.inventory.index')->withFlashDanger('Inventory Deleted Successfully!');
    }
}
