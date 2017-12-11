<?php

namespace App\Models\Commissary\Product;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\Product\Traits\Relationship\ProductRelationship;
use App\Models\Commissary\Product\Traits\Attribute\ProductAttribute;

class Product extends Model
{
	use ProductAttribute, ProductRelationship;
    protected $table = 'commissary_products';

    protected $fillable = ['id', 'name', 'produce', 'category', 'price', 'cost'];
}
