<?php

namespace App\Http\Controllers\Backend\Request;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Request\RequestRepository;
use Yajra\Datatables\Facades\Datatables;

class RequestTableController extends Controller
{

	protected $requests;

	public function __construct(RequestRepository $requests){
		$this->requests = $requests;
	}

	public function __invoke(Request $request){
		return Datatables::of($this->requests->getForDataTable())
				->escapeColumns(['id', 'sort'])
				->addColumn('date', function($request) {
					return $request->created_at->format('F d, Y');
				})
				->addColumn('time', function($request) {
					return $request->created_at->format('h:i:s A');
				})
				->addColumn('user', function($request) {
					return $request->user->full_name;
				})
				->addColumn('status', function($request){
					$label = '<label class="label label-default">Pending</label>';
					if(count($request->response))
					{
						;

						if($request->response->status == 'Accept')
							$label = '<label class="label label-success">Accepted</label>';
						else
							$label = '<label class="label label-danger">Declined</label>';
					}

					return $label;
				})
				->addColumn('actions', function($request){
					return $request->action_buttons;
				})
				->make();
	}
}
