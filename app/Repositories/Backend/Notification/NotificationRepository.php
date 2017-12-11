<?php

namespace App\Repositories\Backend\Notification;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\Notification\Notification;

class NotificationRepository extends BaseRepository
{
	const MODEL = Notification::class;

	public function getForDataTable(){
		return $this->query()
				->with('inventory')->orderBy('date', 'desc');
	}
}