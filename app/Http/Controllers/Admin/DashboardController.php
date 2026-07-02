<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\CurrentInvitation;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $invitation = CurrentInvitation::get();

        $stats = [
            'total_rsvp' => $invitation->rsvps()->count(),
            'hadir' => $invitation->rsvps()->where('attendance', 'hadir')->count(),
            'tidak_hadir' => $invitation->rsvps()->where('attendance', 'tidak_hadir')->count(),
            'ragu' => $invitation->rsvps()->where('attendance', 'masih_ragu')->count(),
            'total_event' => $invitation->eventSchedules()->count(),
            'total_gallery' => $invitation->galleries()->count(),
        ];

        $latestRsvp = $invitation->rsvps()->latest()->limit(5)->get();

        return view('admin.dashboard', compact('invitation', 'stats', 'latestRsvp'));
    }
}
