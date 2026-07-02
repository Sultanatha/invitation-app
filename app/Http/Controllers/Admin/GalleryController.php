<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Support\CurrentInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-gallery')->only(['index', 'edit']);
        $this->middleware('permission:create-gallery')->only(['create', 'store']);
        $this->middleware('permission:update-gallery')->only(['update']);
        $this->middleware('permission:delete-gallery')->only(['destroy']);
    }

    public function index(): View
    {
        $galleries = CurrentInvitation::get()->galleries()->orderBy('sort_order')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create(): View
    {
        return view('admin.gallery.form', ['gallery' => new Gallery()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => ['required', 'image', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        Gallery::create([
            'invitation_id' => CurrentInvitation::get()->id,
            'image' => $request->file('image')->store('gallery', 'public'),
            'caption' => $request->caption,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.form', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $request->validate([
            'image' => ['nullable', 'image', 'max:2048'],
            'caption' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data = $request->only(['caption', 'sort_order']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();
        return redirect()->route('admin.gallery.index')->with('success', 'Foto berhasil dihapus.');
    }
}
