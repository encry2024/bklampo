<?php

namespace App\Models\Category;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category\Traits\Attribute\CategoryAttribute;

class Category extends Model
{
	use CategoryAttribute;

    protected $fillable = ['name'];
}
