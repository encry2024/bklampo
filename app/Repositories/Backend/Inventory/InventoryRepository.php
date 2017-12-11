<?php

namespace App\Repositories\Backend\Inventory;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory\Inventory;

class InventoryRepository extends BaseRepository
{
	const MODEL = Inventory::class;

	public function getForDataTable(){
		return $this->query()
				->with('category');
	}
}