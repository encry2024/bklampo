<?php

namespace App\Http\Controllers\Backend\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Product\ProductRepository;

class ProductTableController extends Controller
{
    protected $products;

    public function __construct(ProductRepository $products){
    	$this->products = $products;
    }

    public function __invoke(Request $request){
    	return Datatables::of($this->products->getForDataTable())
    			->escapeColumns('id', 'sort')
    			->addColumn('image', function($product) {
    				$path 	= url('/img/product').'/'.$product->image;
    				$style	= 'width:64px;height:72px';

    				return '<img src="'.$path.'" style="'.$style.'">';
    			})
    			->addColumn('actions', function($product) {
    				return $product->action_buttons;
    			})
    			->make();
    }
}
