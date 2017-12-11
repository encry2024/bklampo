<?php

namespace App\Models\Stock\Traits\Relationship;

use App\Models\Inventory\Inventory;

trait StockRelationship
{
	public function inventory(){
		return $this->belongsTo(Inventory::class);
	}
}