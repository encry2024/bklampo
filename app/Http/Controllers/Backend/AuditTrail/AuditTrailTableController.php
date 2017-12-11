<?php

namespace App\Http\Controllers\Backend\AuditTrail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\AuditTrail\AuditTrailRepository;

class AuditTrailTableController extends Controller
{
    protected $audit_trails;

    public function __construct(AuditTrailRepository $audit_trails){
    	$this->audit_trails = $audit_trails;
    }

    public function __invoke(Request $request){
    	return Datatables::of($this->audit_trails->getForDataTable())
    		->addColumn('user', function($audit_trail) {
    			return $audit_trail->user->name;
    		})
    		->make();
    }
}
