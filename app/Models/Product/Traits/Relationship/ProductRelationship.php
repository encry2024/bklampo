<?php

namespace App\Models\Product\Traits\Relationship;

use App\Models\ProductSize\ProductSize;
use App\Models\OrderList\OrderList;

/**
 * Class RoleRelationship.
 */
trait ProductRelationship
{

	public function product_size(){
		return $this->hasMany(ProductSize::class);
	}

	public function order_list(){
		return $this->hasMany(OrderList::class);
	}


}