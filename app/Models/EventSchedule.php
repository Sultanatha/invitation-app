<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = [
        'invitation_id',
        'title',
        'event_date',
        'start_time',
        'end_time',
        'venue_name',
        'address',
        'map_url',
        'sort_order',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}
