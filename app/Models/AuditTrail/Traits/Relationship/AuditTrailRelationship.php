<?php

namespace App\Models\AuditTrail\Traits\Relationship;

use App\Models\Access\User\User;

/**
 * Class RoleRelationship.
 */
trait AuditTrailRelationship
{

	public function user(){
		return $this->belongsTo(User::class);
	}

}