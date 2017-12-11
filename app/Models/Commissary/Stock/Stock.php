<?php

namespace App\Models\Commissary\Stock;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Stock\Traits\Attribute\StockAttribute;
use App\Models\Commissary\Stock\Traits\Relationship\StockRelationship;

class Stock extends Model
{
	use StockAttribute, StockRelationship;

    protected $table = 'commissary_stocks';

    protected $fillable = ['id', 'quantity', 'price', 'received', 'expiration', 'status', 'inventory_id'];

}
