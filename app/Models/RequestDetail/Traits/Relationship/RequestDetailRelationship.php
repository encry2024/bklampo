<?php

namespace App\Models\RequestDetail\Traits\Relationship;

use App\Models\Request\RequestMessage;
use App\Models\Inventory\Inventory;


trait RequestDetailRelationship
{
	public function request(){
		return $this->belongsTo(RequestMessage::class, 'request_id');
	}

	public function ingredient(){
		return $this->belongsTo(Inventory::class, 'ingredient_id');
	}
}