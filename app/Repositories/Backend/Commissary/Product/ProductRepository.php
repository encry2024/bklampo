<?php

namespace App\Repositories\Backend\Commissary\Product;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Product\Product;

class ProductRepository extends BaseRepository
{
	const MODEL = Product::class;

	public function getForDataTable(){
		return $this->query()
				->select('id', 'name', 'produce', 'price', 'cost', 'category_id');
	}
}