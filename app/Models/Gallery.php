<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = ['invitation_id', 'image', 'caption', 'sort_order'];
}
