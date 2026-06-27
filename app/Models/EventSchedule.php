<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    protected $fillable = [
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
