<?php

namespace App\Http\Controllers\Backend\Commissary\OrderForm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Inventory;
use App\Models\Stock\Stock;
use App\Models\Category\Category;

class OrderFormController extends Controller
{
	public function index(){
		$friday = date('Y-m-d', strtotime('friday'));
		$monday = date('Y-m-d', strtotime($friday.' -4 days'));

		$records = $this->fetchRecord($monday, $friday);

		// return $records[0];

		return view('backend.commissary.order_form.index', compact('monday', 'friday', 'records'));
	}

	public function store(Request $request){
		$friday = $request->to;
		$monday = $request->from;

		$records = $this->fetchRecord($monday, $friday);

		return view('backend.commissary.order_form.index', compact('monday', 'friday', 'records'));
	}

	public function fetchRecord($from, $to){
		$date_ranges = [];
		$records	 = [];
		$index		 = 0;
		$index2      = 0;

		$categories = Category::where('name', '!=', 'Cleaning Material')->get();

		for($i = 0; $i !=5; $i++)
		{
			$date_ranges[$i] = date('Y-m-d', strtotime($to.' -'.$i.' day'));
		}

		sort($date_ranges);

		foreach($categories as $category)
		{
			$objects = [];
			$inventories = Inventory::where('category_id', $category->id)->get();

			foreach($inventories as $inventory)
			{	
				$quantities   = [];

				for($i = 0; $i < 5; $i++) {
					$stock = Stock::selectRaw('sum(quantity) as quantity')
						->where('received', $date_ranges[$i])
						->where('inventory_id', $inventory->id)
						->first();

					$quantities[$i] = count($stock->quantity) ? $stock->quantity : 0;
				}

				$objects[$index] = 	[
										'name'		 => $inventory->name,
										'critical' 	 => $inventory->reorder_level,
										'unit_type'  => $inventory->unit_type,
										'quantities' => $quantities
									];
				$index++;				
			}

			$records[$index2] = [
									'categories' => $category->name, 
									'items' => $objects, 
									'dates' => $date_ranges
								];
			$index2++;
		}

		return $records;
	}
}
