<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;

use App\Models\Product\Traits\Attribute\ProductAttribute;
use App\Models\Product\Traits\Relationship\ProductRelationship;

class Product extends Model
{
	use ProductAttribute, ProductRelationship;

    protected $fillable = ['id', 'code', 'name', 'image', 'category'];
}
