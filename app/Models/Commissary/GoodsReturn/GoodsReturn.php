<?php

namespace App\Models\Commissary\GoodsReturn;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commissary\GoodsReturn\Traits\Attribute\GoodsReturnAttribute;
use App\Models\Commissary\GoodsReturn\Traits\Relationship\GoodsReturnRelationship;

class GoodsReturn extends Model
{
	use GoodsReturnAttribute, GoodsReturnRelationship;

	protected $table = 'goods_returns';

    protected $fillable = ['id','inventory_id','date','quantity','cost','total_cost','reason','witness'];
}
