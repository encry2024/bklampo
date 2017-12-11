<?php

namespace App\Http\Controllers\Backend\AuditTrail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuditTrailController extends Controller
{
    public function index(){
    	return view('backend.audit_trail.index');
    }
}
