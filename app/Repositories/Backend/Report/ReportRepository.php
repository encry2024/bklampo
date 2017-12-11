<?php

namespace App\Repositories\Backend\Report;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order\Order;

class ReportRepository extends BaseRepository
{
	const MODEL = Order::class;

	public function getForDataTable(){
		return $this->query()
				->select('id', 'transaction_no', 'created_at')
				->orderBy('created_at', 'desc');
	}
}