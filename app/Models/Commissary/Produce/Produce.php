<?php

namespace App\Models\Commissary\Produce;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Produce\Traits\Attribute\ProduceAttribute;
use App\Models\Commissary\Produce\Traits\Relationship\ProduceRelationship;

class Produce extends Model
{
	use ProduceAttribute, ProduceRelationship;
	
    protected $table = 'commissary_produce';

    protected $fillable = ['id', 'product_id', 'quantity', 'date'];
}
