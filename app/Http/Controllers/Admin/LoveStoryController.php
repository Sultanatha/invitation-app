<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoveStory;
use App\Support\CurrentInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoveStoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-love-story')->only(['index', 'edit']);
        $this->middleware('permission:create-love-story')->only(['create', 'store']);
        $this->middleware('permission:update-love-story')->only(['update']);
        $this->middleware('permission:delete-love-story')->only(['destroy']);
    }

    public function index(): View
    {
        $stories = CurrentInvitation::get()->loveStories()->orderBy('sort_order')->get();
        return view('admin.love-story.index', compact('stories'));
    }

    public function create(): View
    {
        return view('admin.love-story.form', ['story' => new LoveStory()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['invitation_id'] = CurrentInvitation::get()->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('love-story', 'public');
        }

        LoveStory::create($data);

        return redirect()->route('admin.love-story.index')->with('success', 'Cerita berhasil ditambahkan.');
    }

    public function edit(LoveStory $story): View
    {
        return view('admin.love-story.form', compact('story'));
    }

    public function update(Request $request, LoveStory $story): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('love-story', 'public');
        }

        $story->update($data);

        return redirect()->route('admin.love-story.index')->with('success', 'Cerita berhasil diperbarui.');
    }

    public function destroy(LoveStory $story): RedirectResponse
    {
        $story->delete();
        return redirect()->route('admin.love-story.index')->with('success', 'Cerita berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'story_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
