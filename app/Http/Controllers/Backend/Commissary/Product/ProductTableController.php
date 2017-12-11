<?php

namespace App\Http\Controllers\Backend\Commissary\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Commissary\Product\ProductRepository;


class ProductTableController extends Controller
{
    protected $products;

    public function __construct(ProductRepository $products){
    	$this->products = $products;
    }

    public function __invoke(Request $request){
    	return Datatables::of($this->products->getForDataTable())
    		->escapeColumns('id', 'sort')
            ->addColumn('category', function($product) {
                return $product->category->name;
            })
    		->addColumn('actions', function($product) {
    			return $product->action_buttons;
    		})
    		->make();
    }
}
