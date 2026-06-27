<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Couple;
use App\Models\EventSchedule;
use App\Models\Gallery;
use App\Models\Gift;
use App\Models\HeroSection;
use App\Models\LoveStory;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Rsvp;

class InvitationController extends Controller
{
    /**
     * Endpoint utama: semua data landing page sekali fetch.
     * GET /api/invitation
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'settings' => $this->settings(),
                'hero' => HeroSection::where('is_active', true)->latest()->first(),
                'couples' => Couple::all(),
                'events' => EventSchedule::orderBy('sort_order')->get(),
                'love_stories' => LoveStory::orderBy('sort_order')->get(),
                'galleries' => Gallery::orderBy('sort_order')->get(),
                'gifts' => Gift::all(),
            ],
        ]);
    }

    public function hero(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => HeroSection::where('is_active', true)->latest()->first(),
        ]);
    }

    public function couples(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => Couple::all()]);
    }

    public function events(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => EventSchedule::orderBy('sort_order')->get()]);
    }

    public function loveStories(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => LoveStory::orderBy('sort_order')->get()]);
    }

    public function galleries(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => Gallery::orderBy('sort_order')->get()]);
    }

    public function gifts(): JsonResponse
    {
        return response()->json(['success' => true, 'data' => Gift::all()]);
    }

    /**
     * Tamu submit RSVP.
     * POST /api/rsvp
     */
    public function storeRsvp(Request $request): JsonResponse
    {
        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'attendance' => ['required', 'in:hadir,tidak_hadir,masih_ragu'],
            'total_guest' => ['nullable', 'integer', 'min:1', 'max:10'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $rsvp = Rsvp::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih telah mengisi RSVP.',
            'data' => $rsvp,
        ], 201);
    }

    public function rsvpList(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Rsvp::latest()->paginate(20),
        ]);
    }

    private function settings(): array
    {
        return [
            'site_title' => Setting::get('site_title', 'Undangan Pernikahan'),
            'site_description' => Setting::get('site_description'),
            'theme_color' => Setting::get('theme_color', '#000000'),
            'whatsapp_admin' => Setting::get('whatsapp_admin'),
        ];
    }
}
