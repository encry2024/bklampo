<?php

namespace App\Models\Notification\Traits\Relationship;

use App\Models\Inventory\Inventory;

/**
 * Class RoleRelationship.
 */
trait NotificationRelationship
{

	public function inventory(){
		return $this->belongsTo(Inventory::class);
	}

}