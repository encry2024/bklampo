<?php

namespace App\Repositories\Backend\AuditTrail;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\AuditTrail\AuditTrail;

class AuditTrailRepository extends BaseRepository
{
	const MODEL = AuditTrail::class;

	public function getForDataTable(){
		return $this->query()
			->selectRaw('id, user_id, description, date(created_at) as "date", time(created_at) as "time"')->with('user')->orderBy('created_at', 'desc');
	}
}