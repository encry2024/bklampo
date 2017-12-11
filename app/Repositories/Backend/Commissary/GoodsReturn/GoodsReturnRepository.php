<?php

namespace App\Repositories\Backend\Commissary\GoodsReturn;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\GoodsReturn\GoodsReturn;

class GoodsReturnRepository extends BaseRepository
{
	const MODEL = GoodsReturn::class;

	public function getForDataTable(){
		return $this->query();
	}
}