<?php

namespace App\Support;

use App\Models\Invitation;

class CurrentInvitation
{
    private const SESSION_KEY = 'admin.current_invitation_id';

    public static function get(): Invitation
    {
        $id = session(self::SESSION_KEY);

        if ($id) {
            $invitation = Invitation::find($id);

            if ($invitation) {
                return $invitation;
            }
        }

        $invitation = Invitation::default();
        self::set($invitation);

        return $invitation;
    }

    public static function set(Invitation $invitation): void
    {
        session([self::SESSION_KEY => $invitation->id]);
    }
}
