<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class Couple extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = [
        'invitation_id',
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
