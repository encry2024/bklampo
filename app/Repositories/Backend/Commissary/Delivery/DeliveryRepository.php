<?php

namespace App\Repositories\Backend\Commissary\Delivery;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Delivery\Delivery;

class DeliveryRepository extends BaseRepository
{
	const MODEL = Delivery::class;

	public function getForDataTable(){
		return $this->query()
				->with('branch')
				->select('id', 'quantity', 'price', 'date', 'item_id', 'branch_id', 'status', 'type');
	}
}