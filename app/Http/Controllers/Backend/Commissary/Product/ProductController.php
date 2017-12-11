<?php

namespace App\Http\Controllers\Backend\Commissary\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\History\History;
use App\Models\Category\Category;

class ProductController extends Controller
{
    public function index(){
        $histories = History::take(10)->orderBy('created_at', 'desc')->get();

    	return view('backend.commissary.product.index', compact('histories'));
    }

    public function show(Product $product){
        return view('backend.commissary.product.show', compact('product'));
    }

    public function create(){
    	$ingredients = Inventory::all();
        $categories = Category::pluck('name', 'id');

    	$selections = $ingredients->pluck('name', 'id');

    	return view('backend.commissary.product.create', compact('ingredients', 'selections', 'categories'));
    }

    public function store(Request $request){
    	$ingredients = json_decode($request->ingredients);

    	$product = new Product();
    	$product->name = $request->name;
        $product->price = $request->price;
    	$product->category_id = $request->category;
    	$product->save();


    	foreach ($ingredients as $item) {
    		$ingredient = Inventory::findOrFail($item->id);

    		$ingredient->products()->attach($product, ['quantity' => $item->quantity]);
    	}

    	return redirect()->route('admin.commissary.product.index');
    }

    public function destroy(Product $product){
        $product->delete();

        return redirect()->route('admin.commissary.product.index')->withFlashDanger('Product has been deleted!');
    }
}
