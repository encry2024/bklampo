<?php

namespace App\Models\Commissary\Dispose\Traits\Relationship;

use App\Models\Commissary\Inventory\Inventory;
use App\Models\Branch\Branch;

/**
 * Class RoleRelationship.
 */
trait DisposeRelationship
{

	public function inventory(){
		return $this->belongsTo(Inventory::class);
	}

	public function branch(){
		return $this->belongsTo(Branch::class);
	}
}