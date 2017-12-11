<?php

namespace App\Models\Commissary\Product\Traits\Relationship;

use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Produce\Produce;
use App\Models\Category\Category;

/**
 * Class RoleRelationship.
 */
trait ProductRelationship
{

	public function ingredients(){
		return $this->belongsToMany(Inventory::class, 'commissary_inventory_product', 'product_id', 'inventory_id')
			->withPivot('quantity', 'created_at');
	}

	public function produced(){
		return $this->hasMany(Produce::class);
	}

	public function category(){
		return $this->belongsTo(Category::class);
	}
}
