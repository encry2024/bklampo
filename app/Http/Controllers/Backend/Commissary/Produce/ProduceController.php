<?php

namespace App\Http\Controllers\Backend\Commissary\Produce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Produce\Produce;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\History\History;

class ProduceController extends Controller
{
    public function index(){
    	return view('backend.commissary.produce.index');
    }

    public function create(){
    	$products = Product::pluck('name', 'id');

    	return view('backend.commissary.produce.create', compact('products'));
    }

    public function store(Request $request) {
        $canProduce = 0;
        $cost       = 0;
        $product    = Product::findOrFail($request->product_id);
        $ingredients= $product->ingredients;

        foreach ($ingredients as $ingredient) {
            if(($request->quantity * $ingredient->pivot->quantity ) <= $ingredient->stock)
                $canProduce++;
        }
        
        // can produce should match the number of ingredients
        // can product mus
        //
        if(count($ingredients) == $canProduce)
        {
            $produce = Produce::updateOrCreate(
                        [
                            'product_id' => $request->product_id,
                            'created_at' => date('Y-m-d h:i:s')
                        ],
                        [
                            'date'      => $request->date,
                            'quantity'  => $request->quantity
                        ]
                    );


            


            foreach ($ingredients as $ingredient) {
               $ingredient->stock = $ingredient->stock - ($ingredient->pivot->quantity * $request->quantity);
;
               if(count($ingredient->stocks))
               {
                    $cost = $cost + $ingredient->stocks->last()->price;
               }

               $ingredient->save();
            }

            $product          = $produce->product;
            $product->produce = $product->produce + $request->quantity;
            $product->cost    = $cost;
            $product->save();

            $history                = new History();
            $history->product_id    = $product->id;
            $history->description   = $request->quantity.' '.$product->name.' has been produced';
            $history->status        = 'Add';
            $history->save();

            return redirect()->route('admin.commissary.produce.index')->withFlashSuccess('Record Saved!');
        }
        else
        {
            return redirect()->back()->withFlashDanger('Check inventory for item stock!');
        }
    }


    public function destroy(Produce $produce){
    	$product = $produce->product;
    	$product->produce = $product->produce - $produce->quantity;
    	$product->save();

        $ingredients = $product->ingredients;

        foreach ($ingredients as $ingredient) {
            $ingredient->stock = $ingredient->stock + $produce->quantity;
            $ingredient->save();
        }

        $produce->delete();

    	return redirect()->route('admin.commissary.produce.index')->withFlashDanger('Produce Product Deleted Successfully!');
    }

}
