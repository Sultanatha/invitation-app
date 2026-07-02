<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = [
        'invitation_id',
        'groom_name',
        'bride_name',
        'event_date',
        'cover_image',
        'background_music',
        'opening_quote',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
    ];
}
