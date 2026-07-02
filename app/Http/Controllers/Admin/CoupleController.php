<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Couple;
use App\Support\CurrentInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoupleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-couple')->only(['index', 'edit']);
        $this->middleware('permission:create-couple')->only(['create', 'store']);
        $this->middleware('permission:update-couple')->only(['update']);
        $this->middleware('permission:delete-couple')->only(['destroy']);
    }

    public function index(): View
    {
        $couples = CurrentInvitation::get()->couples()->orderBy('role')->get();
        return view('admin.couple.index', compact('couples'));
    }

    public function create(): View
    {
        return view('admin.couple.form', ['couple' => new Couple()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['invitation_id'] = CurrentInvitation::get()->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('couple', 'public');
        }

        Couple::create($data);

        return redirect()->route('admin.couple.index')->with('success', 'Data mempelai berhasil ditambahkan.');
    }

    public function edit(Couple $couple): View
    {
        return view('admin.couple.form', compact('couple'));
    }

    public function update(Request $request, Couple $couple): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('couple', 'public');
        }

        $couple->update($data);

        return redirect()->route('admin.couple.index')->with('success', 'Data mempelai berhasil diperbarui.');
    }

    public function destroy(Couple $couple): RedirectResponse
    {
        $couple->delete();
        return redirect()->route('admin.couple.index')->with('success', 'Data mempelai berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'role' => ['required', 'in:groom,bride'],
            'full_name' => ['required', 'string', 'max:255'],
            'nickname' => ['nullable', 'string', 'max:255'],
            'child_order' => ['nullable', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
