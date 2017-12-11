<?php

namespace App\Models\Commissary\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Inventory\Traits\Relationship\InventoryRelationship;
use App\Models\Commissary\Inventory\Traits\Attribute\InventoryAttribute;

class Inventory extends Model
{
	use InventoryAttribute, InventoryRelationship;
	protected $table = 'commissary_inventories';

    protected $fillable = ['id', 'name', 'stock', 'reorder_level', 'unit_type', 'category_id'];
}
