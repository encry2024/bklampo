<?php

namespace App\Http\Controllers\Backend\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Notification\NotificationRepository;
use App\Models\Inventory\Inventory;
use Yajra\Datatables\Facades\Datatables;

class NotificationTableController extends Controller
{
	protected $notifications;

    public function __construct(NotificationRepository $notifications){
    	$this->notifications = $notifications;
    }

    public function __invoke(Request $request){
		return Datatables::of($this->notifications->getForDataTable())
    		->addColumn('item', function($notification) {
    			return $notification->inventory->name;
    		})	
			->make();
    }
}
