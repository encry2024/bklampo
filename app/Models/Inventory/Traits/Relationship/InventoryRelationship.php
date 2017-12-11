<?php

namespace App\Models\Inventory\Traits\Relationship;

use App\Models\Category\Category;
use App\Models\Product\Product;
use App\Models\Stock\Stock;
use App\Models\ProductSize\ProductSize;
use App\Models\Commissary\Product\Product as CommissaryProduct;
use App\Models\Commissary\Inventory\Inventory as CommissaryInventory;
use App\Models\Other\Inventory as Other;

/**
 * Class RoleRelationship.
 */
trait InventoryRelationship
{

	public function category(){
		return $this->belongsTo(Category::class);
	}

	public function product_size(){
		return $this->belongsToMany(ProductSize::class, 'inventory_product_size', 'inventory_id' ,'product_size_id')
			->withPivot('quantity');
	}

	public function stocks(){
		return $this->hasMany(Stock::class);
	}


	public function commissary_product(){
		return $this->belongsTo(CommissaryProduct::class, 'inventory_id');
	}

	public function commissary_inventory(){
		return $this->belongsTo(CommissaryInventory::class, 'inventory_id');
	}

	public function other(){
		return $this->belongsTo(Other::class, 'inventory_id');
	}
}