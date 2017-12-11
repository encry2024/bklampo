<?php

namespace App\Repositories\Backend\Category;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category\Category;

class CategoryRepository extends BaseRepository
{
	const MODEL = Category::class;

	public function getForDataTable(){
		return $this->query()->select('id', 'name');
	}
}