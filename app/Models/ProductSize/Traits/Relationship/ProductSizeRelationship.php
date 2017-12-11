<?php

namespace App\Models\ProductSize\Traits\Relationship;

use App\Models\Product\Product;
use App\Models\Inventory\Inventory;

/**
 * Class RoleRelationship.
 */
trait ProductSizeRelationship
{

	public function product(){
		return $this->belongsTo(Product::class);
	}

	public function ingredients(){
		return $this->belongsToMany(Inventory::class, 'inventory_product_size', 'product_size_id', 'inventory_id')
				->withPivot(['quantity']);
	}

}