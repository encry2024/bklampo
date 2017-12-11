<?php

namespace App\Http\Controllers\Backend\Commissary\GoodsReturn;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Commissary\GoodsReturn\GoodsReturnRepository;
use App\Models\Commissary\GoodsReturn\GoodsReturn;
use App\Models\Commissary\Inventory\Inventory;

class GoodsReturnTableController extends Controller
{
    
	protected $goods_returns;

	public function __construct(GoodsReturnRepository $goods_returns){
		$this->goods_returns = $goods_returns;
	}


	public function __invoke(Request $request){
		return Datatables::of($this->goods_returns->getForDataTable())
			->escapeColumns('id', 'sort')
			->addColumn('name', function($goods_returns) {
				$com = Inventory::findOrFail($goods_returns->inventory_id);	

				return $com->name;
			})
			->addColumn('actions', function($goods_returns) {
				return $goods_returns->action_buttons;
			})
			->make();
	}

}
