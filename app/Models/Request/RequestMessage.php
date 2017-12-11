<?php

namespace App\Models\Request;

use Illuminate\Database\Eloquent\Model;
use App\Models\Request\Traits\Relationship\RequestMessageRelationship;
use App\Models\Request\Traits\Attribute\RequestMessageAttribute;

class RequestMessage extends Model
{
	use RequestMessageAttribute, RequestMessageRelationship;

	protected $table = 'requests';
    protected $fillable = ['id', 'title', 'message', 'user_id'];
}
