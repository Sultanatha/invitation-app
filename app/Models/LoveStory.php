<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoveStory extends Model
{
    protected $fillable = [
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
