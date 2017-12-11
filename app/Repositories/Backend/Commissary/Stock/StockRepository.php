<?php

namespace App\Repositories\Backend\Commissary\Stock;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Stock\Stock;

class StockRepository extends BaseRepository
{
	const MODEL = Stock::class;

	public function getForDataTable(){
		return $this->query()
				->select('id', 'quantity', 'price', 'received', 'expiration', 'status', 'inventory_id');
	}
}