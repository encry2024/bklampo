<?php

namespace App\Http\Controllers\Backend\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category\Category;
use App\Http\Requests\Backend\Category\ManageRequest;


class CategoryController extends Controller
{
    public function index(){
    	$categories = Category::all();

    	return view('backend.category.index', compact('categories'));
    }

    public function create(){
    	return view('backend.category.create');
    }

    public function store(ManageRequest $request){
    	Category::create($request->all());

    	return redirect()->route('admin.category.index')->withFlashSuccess('Category has been Added!');
    }

    public function destroy(Category $category){
    	$category->delete();

    	return redirect()->route('admin.category.index')->withFlashDanger('Category has been Deleted!');
    }
}
