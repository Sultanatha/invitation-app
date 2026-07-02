<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gift;
use App\Support\CurrentInvitation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GiftController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-gift')->only(['index', 'edit']);
        $this->middleware('permission:create-gift')->only(['create', 'store']);
        $this->middleware('permission:update-gift')->only(['update']);
        $this->middleware('permission:delete-gift')->only(['destroy']);
    }

    public function index(): View
    {
        $gifts = CurrentInvitation::get()->gifts()->latest()->get();
        return view('admin.gifts.index', compact('gifts'));
    }

    public function create(): View
    {
        return view('admin.gifts.form', ['gift' => new Gift()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateData($request);
        $data['invitation_id'] = CurrentInvitation::get()->id;

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('gifts', 'public');
        }

        Gift::create($data);

        return redirect()->route('admin.gifts.index')->with('success', 'Info hadiah berhasil ditambahkan.');
    }

    public function edit(Gift $gift): View
    {
        return view('admin.gifts.form', compact('gift'));
    }

    public function update(Request $request, Gift $gift): RedirectResponse
    {
        $data = $this->validateData($request);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('gifts', 'public');
        }

        $gift->update($data);

        return redirect()->route('admin.gifts.index')->with('success', 'Info hadiah berhasil diperbarui.');
    }

    public function destroy(Gift $gift): RedirectResponse
    {
        $gift->delete();
        return redirect()->route('admin.gifts.index')->with('success', 'Info hadiah berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:bank,ewallet,address'],
            'provider_name' => ['required', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:1024'],
        ]);
    }
}
