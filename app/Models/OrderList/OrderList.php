<?php

namespace App\Models\OrderList;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderList\Traits\Attribute\OrderListAttribute;
use App\Models\OrderList\Traits\Relationship\OrderListRelationship;

class OrderList extends Model
{
    use OrderListAttribute, OrderListRelationship;

    protected $fillable = ['order_id', 'product_id', 'price', 'quantity', 'size'];
}
