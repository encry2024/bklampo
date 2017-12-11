<?php

namespace App\Models\Commissary\Stock\Traits\Relationship;

use App\Models\Commissary\Inventory\Inventory;

trait StockRelationship
{
	public function inventory(){
		return $this->belongsTo(Inventory::class);
	}
}