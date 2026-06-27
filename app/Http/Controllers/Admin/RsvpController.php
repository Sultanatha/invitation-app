<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rsvp;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RsvpController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-rsvp')->only(['index']);
        $this->middleware('permission:delete-rsvp')->only(['destroy']);
    }

    public function index(): View
    {
        $rsvps = Rsvp::latest()->paginate(15);
        return view('admin.rsvp.index', compact('rsvps'));
    }

    public function destroy(Rsvp $rsvp): RedirectResponse
    {
        $rsvp->delete();
        return redirect()->route('admin.rsvp.index')->with('success', 'Data RSVP berhasil dihapus.');
    }
}
