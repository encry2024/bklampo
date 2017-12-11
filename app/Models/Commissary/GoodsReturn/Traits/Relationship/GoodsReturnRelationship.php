<?php

namespace App\Models\Commissary\GoodsReturn\Traits\Relationship;

use App\Models\Commissary\Inventory\Inventory as Commissary;
use App\Models\Inventory\Inventory as POS;

/**
 * Class RoleRelationship.
 */
trait GoodsReturnRelationship
{

	public function inventory(){
		return $this->belongsTo(Commissary::class, 'inventory_id');
	}

}