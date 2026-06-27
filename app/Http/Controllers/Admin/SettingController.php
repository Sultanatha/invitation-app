<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view-setting')->only(['index']);
        $this->middleware('permission:update-setting')->only(['update']);
    }

    public function index(): View
    {
        $settings = [
            'site_title' => Setting::get('site_title'),
            'site_description' => Setting::get('site_description'),
            'theme_color' => Setting::get('theme_color', '#000000'),
            'whatsapp_admin' => Setting::get('whatsapp_admin'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_title' => ['nullable', 'string', 'max:255'],
            'site_description' => ['nullable', 'string'],
            'theme_color' => ['nullable', 'string', 'max:20'],
            'whatsapp_admin' => ['nullable', 'string', 'max:50'],
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
