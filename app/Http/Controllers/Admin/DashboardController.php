<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSchedule;
use App\Models\Gallery;
use App\Models\Rsvp;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_rsvp' => Rsvp::count(),
            'hadir' => Rsvp::where('attendance', 'hadir')->count(),
            'tidak_hadir' => Rsvp::where('attendance', 'tidak_hadir')->count(),
            'ragu' => Rsvp::where('attendance', 'masih_ragu')->count(),
            'total_event' => EventSchedule::count(),
            'total_gallery' => Gallery::count(),
        ];

        $latestRsvp = Rsvp::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'latestRsvp'));
    }
}
