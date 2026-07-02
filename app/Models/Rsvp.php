<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = [
        'invitation_id',
        'guest_name',
        'attendance',
        'total_guest',
        'message',
    ];
}
