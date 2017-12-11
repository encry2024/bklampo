<?php

namespace App\Http\Controllers\Backend\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Notification\Notification;

class NotificationController extends Controller
{
    public function index(){
    	return view('backend.notification.index');
    }


	public function readAll(){
		$notifications = Notification::where('status','new')->get();

		foreach ($notifications as $notification) {
			$notification->status = 'read';
			$notification->save();
		}

		return 'success';
	}

}
