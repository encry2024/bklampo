<?php

namespace App\Repositories\Backend\Product;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product\Product;

class ProductRepository extends BaseRepository
{
	const MODEL = Product::class;

	public function getForDataTable(){
		return $this->query()
				->select('id', 'name', 'code', 'image', 'category');
	}
}