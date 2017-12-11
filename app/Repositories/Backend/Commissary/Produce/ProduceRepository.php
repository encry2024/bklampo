<?php

namespace App\Repositories\Backend\Commissary\Produce;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Produce\Produce;

class ProduceRepository extends BaseRepository
{
	const MODEL = Produce::class;

	public function getForDataTable(){
		return $this->query()
				->select('id', 'quantity', 'date');
	}
}