<?php

namespace App\Models\OrderList\Traits\Relationship;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Models\ProductSize\ProductSize;

/**
 * Class RoleRelationship.
 */
trait OrderListRelationship
{

	public function order(){
		return $this->belongsTo(Order::class);
	}

	public function product(){
		return $this->belongsTo(Product::class);
	}

	public function product_size(){
		return $this->belongsTo(ProductSize::class, 'product_size_id');
	}
}