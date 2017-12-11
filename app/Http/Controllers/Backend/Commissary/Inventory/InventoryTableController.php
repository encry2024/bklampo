<?php

namespace App\Http\Controllers\Backend\Commissary\Inventory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Commissary\Inventory\InventoryRepository;
use App\Models\Commissary\Inventory\Inventory;

class InventoryTableController extends Controller
{
    
	protected $inventories;

	public function __construct(InventoryRepository $inventories){
		$this->inventories = $inventories;
	}


	public function __invoke(Request $request){
		return Datatables::of($this->inventories->getForDataTable())
			->escapeColumns('id', 'sort')
			->addColumn('category', function($inventory) {
				return $inventory->category->name;
			})
			->addColumn('actions', function($inventory) {
				return $inventory->action_buttons;
			})
			->make();
	}

}
