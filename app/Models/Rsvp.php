<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    protected $fillable = [
        'guest_name',
        'attendance',
        'total_guest',
        'message',
    ];
}
