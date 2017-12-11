<?php

namespace App\Models\Response;

use Illuminate\Database\Eloquent\Model;

class ResponseMessage extends Model
{
	protected $table = 'responses';
    protected $fillable = ['id', 'request_id', 'message', 'status'];
}
