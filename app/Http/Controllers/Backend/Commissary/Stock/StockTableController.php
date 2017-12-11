<?php

namespace App\Http\Controllers\Backend\Commissary\Stock;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Commissary\Stock\StockRepository;
use App\Models\Commissary\Stock\Stock;
use Illuminate\Http\Request;

/**
 * Class UserTableController.
 */
class StockTableController extends Controller
{
    
    protected $stocks;

    public function __construct(StockRepository $stocks){
        $this->stocks = $stocks;
    }

    public function __invoke(Request $request){
        return Datatables::of($this->stocks->getForDataTable())
	        ->escapeColumns(['id', 'sort'])
            ->addColumn('inventories', function($stock) {
                return $stock->inventory->name;
            })
        	->addColumn('actions', function($stock) {
        		return $stock->action_buttons;
        	})
            ->make();
    }

}
