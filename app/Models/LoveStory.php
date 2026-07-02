<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class LoveStory extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = [
        'invitation_id',
        'title',
        'story_date',
        'description',
        'photo',
        'sort_order',
    ];

    protected $casts = [
        'story_date' => 'date',
    ];
}
