<?php

namespace App\Http\Controllers\Backend\Stock;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Stock\StockRepository;
use App\Http\Requests\Backend\Stock\StoreStockRequest;
use App\Models\Stock\Stock;
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
                $inventory = $stock->inventory;

                if($inventory->supplier == 'Other')
                {
                    return $inventory->other->name;
                }
                elseif($inventory->supplier == 'Commissary Product')
                {
                    return $inventory->commissary_product->name;
                }
                else
                {
                    return $inventory->commissary_inventory->name;
                }
            })
        	->addColumn('actions', function($stock) {
        		return $stock->action_buttons;
        	})
            ->make();
    }

}
