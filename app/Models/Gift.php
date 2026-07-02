<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = [
        'invitation_id',
        'type',
        'provider_name',
        'account_number',
        'account_name',
        'note',
        'logo',
    ];
}
