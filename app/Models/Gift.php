<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'type',
        'provider_name',
        'account_number',
        'account_name',
        'note',
        'logo',
    ];
}
