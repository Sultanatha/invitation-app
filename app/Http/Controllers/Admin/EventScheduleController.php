<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-event')->only(['index', 'edit']);
        $this->middleware('permission:create-event')->only(['create', 'store']);
        $this->middleware('permission:update-event')->only(['update']);
        $this->middleware('permission:delete-event')->only(['destroy']);
    }

    public function index(): View
    {
        $events = EventSchedule::orderBy('sort_order')->get();
        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.form', ['event' => new EventSchedule()]);
    }

    public function store(Request $request): RedirectResponse
    {
        EventSchedule::create($this->validateData($request));
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil ditambahkan.');
    }

    public function edit(EventSchedule $event): View
    {
        return view('admin.events.form', compact('event'));
    }

    public function update(Request $request, EventSchedule $event): RedirectResponse
    {
        $event->update($this->validateData($request));
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil diperbarui.');
    }

    public function destroy(EventSchedule $event): RedirectResponse
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'start_time' => ['required'],
            'end_time' => ['nullable'],
            'venue_name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'map_url' => ['nullable', 'url'],
            'sort_order' => ['nullable', 'integer'],
        ]);
    }
}
