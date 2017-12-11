<?php

namespace App\Http\Controllers\Backend\Request;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Request\RequestMessage;
use App\Models\Response\ResponseMessage;

class RequestController extends Controller
{
	public function index(){
		return view('backend.request.index');
	}

	public function show($id){
		$msg = RequestMessage::findOrFail($id);
		
		return view('backend.request.show', compact('msg'));
	}

	public function edit($id){
		$msg = RequestMessage::findOrFail($id);

		return view('backend.request.edit', compact('msg'));
	}

	public function update(RequestMessage $request, Request $response){
		$res = new ResponseMessage();
		$res->request_id = $request->id;
		$res->message    = $response->response;
		$res->status     = $response->status;
		$res->save();

		return redirect()->route('admin.request.index')->withFlashSuccess('Response sent successfully!');
	}
}
