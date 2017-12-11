<?php

namespace App\Models\Commissary\Delivery;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Delivery\Traits\Attribute\DeliveryAttribute;
use App\Models\Commissary\Delivery\Traits\Relationship\DeliveryRelationship;

class Delivery extends Model
{
	use DeliveryAttribute, DeliveryRelationship;

	protected $table = 'commissary_deliveries';

    protected $fillable = ['id', 'item_id', 'branch_id', 'quantity', 'date', 'price', 'type'];
}
