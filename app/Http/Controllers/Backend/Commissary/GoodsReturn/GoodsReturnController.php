<?php

namespace App\Http\Controllers\Backend\Commissary\GoodsReturn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\GoodsReturn\GoodsReturn;

class GoodsReturnController extends Controller
{
    public function index(){
    	return view('backend.commissary.goods_return.index');
    }

    public function create(){
    	$commissaries  = Inventory::orderBy('name')->get()->pluck('name', 'id');

    	return view('backend.commissary.goods_return.create', compact('commissaries'));
    }

    public function store(Request $request){
        $inventory = Inventory::findOrFail($request->inventory_id);

        if($request->quantity <= $inventory->stock)
        {
            $goods                  = new GoodsReturn();
            $goods->inventory_id    = $inventory->id;
            $goods->date            = $request->date;
            $goods->quantity        = $request->quantity;
            $goods->cost            = $inventory->stocks->last()->price;
            $goods->total_cost      = $goods->cost * $goods->quantity;
            $goods->witness         = $request->witness;
            $goods->reason          = $request->reason;
            $goods->save();

            // $inventory->stock       = $inventory->stock + $goods->quantity;
            // $inventory->save();

            return redirect()->route('admin.commissary.goods_return.index')->withFlashSuccess('Goods Return has been recorded!');
        }
    	
    	return redirect()->back()->withFlashDanger('Dispose quantity is greater than stocks');
    }

    public function destroy(GoodsReturn $goods_return){
        $inventory = Inventory::findOrFail($goods->inventory_id);
        $inventory->stock = $inventory->stock + $goods_return->quantity;
        $inventory->save();

    	$goods_return->delete();

    	return redirect()->route('admin.commissary.goods_return.index')->withFlashDanger('Record has been deleted!');
    }
}
