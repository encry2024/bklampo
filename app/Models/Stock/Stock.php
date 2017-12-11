<?php

namespace App\Models\Stock;

use Illuminate\Database\Eloquent\Model;

use App\Models\Stock\Traits\Relationship\StockRelationship;

use App\Repositories\Stock\StockRepository;

use App\Models\Stock\Traits\Attribute\StockAttribute;

class Stock extends Model
{
	use StockRelationship, StockAttribute; 

    protected $fillable = ['id', 'quantity', 'price','received','expiration','inventory_id'];
}
