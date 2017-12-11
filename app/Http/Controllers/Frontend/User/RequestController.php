<?php

namespace App\Http\Controllers\Frontend\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Inventory\Inventory;
use App\Models\Request\RequestMessage;
use App\Models\RequestDetail\RequestDetail;
use Auth;

class RequestController extends Controller
{
    public function index(){
    	$requests = RequestMessage::orderBy('id', 'desc')->get();

    	return view('frontend.user.request.index', compact('requests'));
    }

    public function create(){
    	$inventories = Inventory::all();
        $ingredients = [];
        $selections  = [];

        foreach($inventories as $inventory)
        {
            $name = '';
            $temp = [];

            if($inventory->supplier == 'Other')
            {
                $name = $inventory->other->name;
            }
            else if($inventory->supplier == 'Commissary Product')
            {
                $name = $inventory->commissary_product->name;
            }
            else
            {
                $name = $inventory->commissary_inventory->name;
            }

            $selections[$inventory->id] = $name;
            $temp = ['id' => $inventory->id, 'name' => $name];

            array_push($ingredients, $temp);
        }

        $selections = (object)$selections;

        return view('frontend.user.request.create', compact('selections', 'ingredients'));
    }

    public function store(Request $request){
    	$request['requests'] = json_decode($request->requests);

    	$req_msg   		  = new RequestMessage();
    	$req_msg->title   = $request->title;
    	$req_msg->message = $request->message;
    	$req_msg->user_id = Auth::user()->id;
    	$req_msg->save();

    	foreach ($request->requests as $object) 
    	{
			$req_detail 				= new RequestDetail();
			$req_detail->ingredient_id  = $object->id;
			$req_detail->quantity 		= $object->quantity;
			$req_detail->unit_type		= $object->unit_type;
			$req_detail->request()->associate($req_msg);
			$req_detail->save();
    	}

    	return redirect()->route('frontend.user.request.index')->withFlashSuccess('Request has been sent!');
    }

    public function show($id){
        $request = RequestMessage::findOrFail($id);
        
        return view('frontend.user.request.show', compact('request'));
    }

    public function unit($id){
    	$ingredient = Inventory::findOrFail($id);

    	return $ingredient->unit_type;
    }
}
