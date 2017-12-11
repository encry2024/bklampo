<?php

namespace App\Http\Controllers\Backend\Branch;

use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Repositories\Backend\Branch\BranchRepository;
use App\Models\Branch\Branch;
use Illuminate\Http\Request;

/**
 * Class UserTableController.
 */
class BranchTableController extends Controller
{
    
    protected $branch;

    public function __construct(BranchRepository $branch){
        $this->branch = $branch;
    }

    public function __invoke(Request $request){
        return Datatables::of($this->branch->getForDataTable())
	        ->escapeColumns(['id', 'sort'])
        	->addColumn('actions', function($branch) {
        		return $branch->action_buttons;
        	})
            ->make();
    }

}
