<?php

namespace App\Models\Commissary\Inventory\Traits\Relationship;

use App\Models\Category\Category;
use App\Models\Commissary\Product\Product;
use App\Models\Commissary\Inventory\Inventory;
use App\Models\Commissary\Stock\Stock;

/**
 * Class RoleRelationship.
 */
trait InventoryRelationship
{

	public function category(){
		return $this->belongsTo(Category::class);
	}

	public function stocks(){
		return $this->hasMany(Stock::class);
	}

	public function products(){
		return $this->belongsToMany(Product::class, 'commissary_inventory_product', 'inventory_id', 'product_id');
	}
}