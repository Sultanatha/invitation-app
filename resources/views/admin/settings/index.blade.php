@extends('admin.layouts.app')
@section('title', 'Pengaturan')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
    @csrf
    @method('PUT')

    <div><label class="block text-sm font-medium mb-1">Judul Situs</label><input type="text" name="site_title" value="{{ old('site_title', $settings['site_title']) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Deskripsi Situs</label><textarea name="site_description" class="w-full border rounded px-3 py-2 text-sm">{{ old('site_description', $settings['site_description']) }}</textarea></div>
    <div><label class="block text-sm font-medium mb-1">Warna Tema</label><input type="color" name="theme_color" value="{{ old('theme_color', $settings['theme_color']) }}" class="w-20 h-10 border rounded"></div>
    <div><label class="block text-sm font-medium mb-1">No. WhatsApp Admin</label><input type="text" name="whatsapp_admin" value="{{ old('whatsapp_admin', $settings['whatsapp_admin']) }}" class="w-full border rounded px-3 py-2 text-sm" placeholder="62812xxxxxxx"></div>

    @can('update-setting')
    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    @endcan
</form>
</div>
@endsection
