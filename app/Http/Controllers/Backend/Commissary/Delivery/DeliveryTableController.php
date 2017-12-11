<?php

namespace App\Http\Controllers\Backend\Commissary\Delivery;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Commissary\Delivery\DeliveryRepository;
use App\Models\Commissary\Delivery\Delivery;
use App\Models\Commissary\Inventory\Inventory;

class DeliveryTableController extends Controller
{
    
	protected $deliveries;

	public function __construct(DeliveryRepository $deliveries){
		$this->deliveries = $deliveries;
	}


	public function __invoke(Request $request){
		return Datatables::of($this->deliveries->getForDataTable())
			->escapeColumns('id', 'sort')
			->addColumn('item', function($deliveries) {
				if($deliveries->type == 'PRODUCT')
				{
					return $deliveries->product->name;
				}

				return $deliveries->inventory->name;
			})
			->addColumn('branch', function($deliveries) {
				return $deliveries->branch->name;
			})
			->addColumn('total', function($deliveries) {
				$total = $deliveries->quantity * $deliveries->price;

				return number_format($total, 2);
			})
			->addColumn('actions', function($deliveries) {
				return $deliveries->action_buttons;
			})
			->make();
	}

}
