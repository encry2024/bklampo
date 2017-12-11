<?php

namespace App\Repositories\Backend\Branch;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch\Branch;

class BranchRepository extends BaseRepository
{
	const MODEL = Branch::class;

	public function getForDataTable(){
		return $this->query()->select('id', 'name', 'address', 'contact');
	}
}