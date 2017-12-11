<?php

namespace App\Models\Other;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'other_inventories';

    protected $fillable = ['name'];
}
