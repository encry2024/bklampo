<?php

namespace App\Http\Controllers\Backend\Commissary\Produce;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Commissary\Produce\ProduceRepository;
use App\Models\Commissary\Produce\Produce;


class ProduceTableController extends Controller
{
    protected $produces;

    public function __construct(ProduceRepository $produces){
    	$this->produces = $produces;
    }

    public function __invoke(Request $request){
    	return Datatables::of($this->produces->getForDataTable())
    		->escapeColumns('id', 'sort')
            ->addColumn('products', function($produce) {
                $produce = Produce::findOrFail($produce->id);
                return $produce->product->name;
            })
    		->addColumn('actions', function($product) {
    			return $product->action_buttons;
    		})
    		->make(true);
    }
}
