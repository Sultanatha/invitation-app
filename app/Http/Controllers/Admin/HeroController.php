<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Support\CurrentInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-hero')->only(['index', 'edit']);
        $this->middleware('permission:create-hero')->only(['create', 'store']);
        $this->middleware('permission:update-hero')->only(['update']);
        $this->middleware('permission:delete-hero')->only(['destroy']);
    }

    public function index(): View
    {
        $heroes = CurrentInvitation::get()->heroSections()->latest()->paginate(10);
        return view('admin.hero.index', compact('heroes'));
    }

    public function create(): View
    {
        return view('admin.hero.form', ['hero' => new HeroSection()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['invitation_id'] = CurrentInvitation::get()->id;
        $data['cover_image'] = $this->handleUpload($request, 'cover_image');

        HeroSection::create($data);

        return redirect()->route('admin.hero.index')->with('success', 'Hero section berhasil ditambahkan.');
    }

    public function edit(HeroSection $hero): View
    {
        return view('admin.hero.form', compact('hero'));
    }

    public function update(Request $request, HeroSection $hero): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->handleUpload($request, 'cover_image');
        }

        $hero->update($data);

        return redirect()->route('admin.hero.index')->with('success', 'Hero section berhasil diperbarui.');
    }

    public function destroy(HeroSection $hero): RedirectResponse
    {
        $hero->delete();
        return redirect()->route('admin.hero.index')->with('success', 'Hero section berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'groom_name' => ['required', 'string', 'max:255'],
            'bride_name' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'opening_quote' => ['nullable', 'string'],
            'background_music' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    private function handleUpload(Request $request, string $field): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        return $request->file($field)->store('hero', 'public');
    }
}
