<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Couple extends Model
{
    protected $fillable = [
        'role',
        'full_name',
        'nickname',
        'child_order',
        'father_name',
        'mother_name',
        'bio',
        'photo',
        'instagram',
    ];
}
