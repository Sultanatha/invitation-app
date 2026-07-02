<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    /**
     * Endpoint utama: semua data landing page sekali fetch.
     * GET /api/invitation
     */
    public function index(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json([
            'success' => true,
            'data' => [
                'invitation' => $invitation,
                'settings' => $this->settings($invitation),
                'hero' => $invitation->heroSections()->where('is_active', true)->latest()->first(),
                'couples' => $invitation->couples()->get(),
                'events' => $invitation->eventSchedules()->orderBy('sort_order')->get(),
                'love_stories' => $invitation->loveStories()->orderBy('sort_order')->get(),
                'galleries' => $invitation->galleries()->orderBy('sort_order')->get(),
                'gifts' => $invitation->gifts()->get(),
            ],
        ]);
    }

    public function hero(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json([
            'success' => true,
            'data' => $invitation->heroSections()->where('is_active', true)->latest()->first(),
        ]);
    }

    public function couples(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json(['success' => true, 'data' => $invitation->couples()->get()]);
    }

    public function events(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json(['success' => true, 'data' => $invitation->eventSchedules()->orderBy('sort_order')->get()]);
    }

    public function loveStories(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json(['success' => true, 'data' => $invitation->loveStories()->orderBy('sort_order')->get()]);
    }

    public function galleries(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json(['success' => true, 'data' => $invitation->galleries()->orderBy('sort_order')->get()]);
    }

    public function gifts(?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        return response()->json(['success' => true, 'data' => $invitation->gifts()->get()]);
    }

    /**
     * Tamu submit RSVP.
     * POST /api/rsvp
     */
    public function storeRsvp(Request $request, ?Invitation $invitation = null): JsonResponse
    {
        $invitation = $this->resolveInvitation($invitation);

        $data = $request->validate([
            'guest_name' => ['required', 'string', 'max:255'],
            'attendance' => ['required', 'in:hadir,tidak_hadir,masih_ragu'],
            'total_guest' => ['nullable', 'integer', 'min:1', 'max:10'],
            'message' => ['nullable', 'string', 'max:1000'],
        ]);

        $rsvp = $invitation->rsvps()->create($data);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih telah mengisi RSVP.',
            'data' => $rsvp,
        ], 201);
    }

    public function rsvpList(): JsonResponse
    {
        $invitation = Invitation::default();

        return response()->json([
            'success' => true,
            'data' => $invitation->rsvps()->latest()->paginate(20),
        ]);
    }

    private function settings(Invitation $invitation): array
    {
        return [
            'site_title' => Setting::get('site_title', 'Undangan Pernikahan', $invitation),
            'site_description' => Setting::get('site_description', null, $invitation),
            'theme_color' => Setting::get('theme_color', '#000000', $invitation),
            'whatsapp_admin' => Setting::get('whatsapp_admin', null, $invitation),
        ];
    }

    private function resolveInvitation(?Invitation $invitation): Invitation
    {
        if ($invitation?->exists) {
            return $invitation;
        }

        return Invitation::default();
    }
}
