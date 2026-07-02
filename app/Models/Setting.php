<?php

namespace App\Models;

use App\Models\Concerns\AssignsDefaultInvitation;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use AssignsDefaultInvitation;

    protected $fillable = ['invitation_id', 'key', 'value'];

    public static function get(string $key, $default = null, ?Invitation $invitation = null)
    {
        $invitation ??= Invitation::default();

        return static::where('invitation_id', $invitation->id)
            ->where('key', $key)
            ->value('value') ?? $default;
    }

    public static function set(string $key, $value, ?Invitation $invitation = null): void
    {
        $invitation ??= Invitation::default();

        static::updateOrCreate(
            ['invitation_id' => $invitation->id, 'key' => $key],
            ['value' => $value]
        );
    }
}
