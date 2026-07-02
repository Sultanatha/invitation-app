<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Support\CurrentInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InvitationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-invitation')->only(['index', 'edit', 'switch']);
        $this->middleware('permission:create-invitation')->only(['create', 'store']);
        $this->middleware('permission:update-invitation')->only(['update']);
        $this->middleware('permission:delete-invitation')->only(['destroy']);
    }

    public function index(): View
    {
        $invitations = Invitation::latest()->paginate(12);
        $currentInvitation = CurrentInvitation::get();

        return view('admin.invitations.index', compact('invitations', 'currentInvitation'));
    }

    public function create(): View
    {
        return view('admin.invitations.form', ['invitation' => new Invitation()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->normalizeSlug($data['slug'] ?? $data['title']);
        $data['frontend_url'] = $this->normalizeUrl($data['frontend_url'] ?? null);
        $data['is_active'] = $request->boolean('is_active');

        $invitation = Invitation::create($data);
        CurrentInvitation::set($invitation);

        return redirect()->route('admin.invitations.index')->with('success', 'Undangan berhasil dibuat dan dipilih untuk dikelola.');
    }

    public function edit(Invitation $invitation): View
    {
        return view('admin.invitations.form', compact('invitation'));
    }

    public function update(Request $request, Invitation $invitation): RedirectResponse
    {
        $data = $this->validateData($request, $invitation);
        $data['slug'] = $this->normalizeSlug($data['slug'] ?? $data['title']);
        $data['frontend_url'] = $this->normalizeUrl($data['frontend_url'] ?? null);
        $data['is_active'] = $request->boolean('is_active');

        $invitation->update($data);

        return redirect()->route('admin.invitations.index')->with('success', 'Undangan berhasil diperbarui.');
    }

    public function destroy(Invitation $invitation): RedirectResponse
    {
        if ($invitation->slug === 'default' || Invitation::count() === 1) {
            return redirect()->route('admin.invitations.index')->with('error', 'Undangan default atau satu-satunya undangan tidak bisa dihapus.');
        }

        $invitation->delete();
        CurrentInvitation::set(Invitation::default());

        return redirect()->route('admin.invitations.index')->with('success', 'Undangan berhasil dihapus.');
    }

    public function switch(Invitation $invitation): RedirectResponse
    {
        CurrentInvitation::set($invitation);

        return redirect()->route('admin.dashboard')->with('success', 'Sekarang mengelola undangan: '.$invitation->title.'.');
    }

    private function validateData(Request $request, ?Invitation $invitation = null): array
    {
        $id = $invitation?->id ?? 'NULL';

        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:invitations,slug,'.$id],
            'frontend_url' => ['nullable', 'url', 'max:255'],
            'template_key' => ['required', 'string', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function normalizeSlug(string $value): string
    {
        return Str::slug($value) ?: 'undangan';
    }

    private function normalizeUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        return $value === '' ? null : $value;
    }
}
