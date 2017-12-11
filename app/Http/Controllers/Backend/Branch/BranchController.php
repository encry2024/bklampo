<?php

namespace App\Http\Controllers\Backend\Branch;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Branch\Branch;

class BranchController extends Controller
{
	public function index(){
		return view('backend.branch.index');
	}

	public function create(){
		return view('backend.branch.create');
	}

	public function store(Request $request){
		Branch::create($request->all());

		return redirect()->route('admin.branch.index')->withFlashSuccess('New Branch has been created.');
	}

	public function edit(Branch $branch)
	{
		return view('backend.branch.edit', compact('branch'));
	}

	public function update(Branch $branch, Request $request)
	{
		$branch->update($request->all());
		
		return redirect()->route('admin.branch.index')->withFlashSuccess('Branch has been updated!');
	}

	public function destroy(Branch $branch){
    	$branch->delete();

    	return redirect()->route('admin.branch.index')->withFlashSuccess('Branch has been deleted!');
    }
}
