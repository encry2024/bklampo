<?php

namespace App\Models\AuditTrail;

use Illuminate\Database\Eloquent\Model;
use App\Models\AuditTrail\Traits\Relationship\AuditTrailRelationship;

class AuditTrail extends Model
{
	use AuditTrailRelationship;

    protected $fillable = ['user_id', 'description']; 
}
