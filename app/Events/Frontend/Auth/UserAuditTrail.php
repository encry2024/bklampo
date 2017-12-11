<?php

namespace App\Events\Frontend\Auth;

use Illuminate\Queue\SerializesModels;
use App\Models\AuditTrail\AuditTrail;

class UserAuditTrail
{
    use SerializesModels;

    public function __construct($user, $description)
    {
        $audit = new AuditTrail();
        $audit->user_id = $user->id;
        $audit->description = $description;
        $audit->save();

    }

}
