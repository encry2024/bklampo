<?php

namespace App\Repositories\Backend\Request;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Request\RequestMessage;

class RequestRepository extends BaseRepository
{
	const MODEL = RequestMessage::class;

	public function getForDataTable(){
		return $this->query();
	}
}