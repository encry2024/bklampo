<?php

namespace App\Http\Controllers\Backend\Report\Commissary\Disposal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Commissary\Dispose\Dispose;

class ReportController extends Controller
{
    public function index(){
    	$disposals = Dispose::with('inventory')->where('date', date('Y-m-d'))->get();

    	return view('backend.report.commissary.disposal.index', compact('disposals'));
    }

    public function store(Request $request){
    	$disposals = Dispose::with('inventory')->where('date', $request->date)->get();

    	return view('backend.report.commissary.disposal.index', compact('disposals'));
    }
}
