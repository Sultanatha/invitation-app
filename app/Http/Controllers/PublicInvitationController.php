<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Setting;
use Illuminate\View\View;

class PublicInvitationController extends Controller
{
    public function show(Invitation $invitation): View
    {
        abort_unless($invitation->is_active, 404);

        return view('public.invitation', [
            'invitation' => $invitation,
            'settings' => [
                'site_title' => Setting::get('site_title', 'Undangan Pernikahan', $invitation),
                'site_description' => Setting::get('site_description', null, $invitation),
                'theme_color' => Setting::get('theme_color', '#be3455', $invitation),
                'whatsapp_admin' => Setting::get('whatsapp_admin', null, $invitation),
            ],
            'hero' => $invitation->heroSections()->where('is_active', true)->latest()->first(),
            'couples' => $invitation->couples()->orderBy('role')->get(),
            'events' => $invitation->eventSchedules()->orderBy('sort_order')->get(),
            'loveStories' => $invitation->loveStories()->orderBy('sort_order')->get(),
            'galleries' => $invitation->galleries()->orderBy('sort_order')->get(),
            'gifts' => $invitation->gifts()->latest()->get(),
        ]);
    }
}
