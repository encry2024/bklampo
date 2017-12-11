<?php

namespace App\Models\Commissary\Produce\Traits\Relationship;

use App\Models\Commissary\Product\Product;

/**
 * Class RoleRelationship.
 */
trait ProduceRelationship
{

	public function product(){
		return $this->belongsTo(Product::class);
	}

}