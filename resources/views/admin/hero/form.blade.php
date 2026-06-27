@extends('admin.layouts.app')
@section('title', $hero->exists ? 'Edit Hero' : 'Tambah Hero')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $hero->exists ? route('admin.hero.update', $hero) : route('admin.hero.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @if ($hero->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium mb-1">Nama Mempelai Pria</label>
        <input type="text" name="groom_name" value="{{ old('groom_name', $hero->groom_name) }}" class="w-full border rounded px-3 py-2 text-sm" required>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Nama Mempelai Wanita</label>
        <input type="text" name="bride_name" value="{{ old('bride_name', $hero->bride_name) }}" class="w-full border rounded px-3 py-2 text-sm" required>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Tanggal Acara</label>
        <input type="date" name="event_date" value="{{ old('event_date', $hero->event_date?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 text-sm" required>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Kutipan Pembuka</label>
        <textarea name="opening_quote" class="w-full border rounded px-3 py-2 text-sm">{{ old('opening_quote', $hero->opening_quote) }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">URL Musik Latar (opsional)</label>
        <input type="text" name="background_music" value="{{ old('background_music', $hero->background_music) }}" class="w-full border rounded px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Cover Image</label>
        <input type="file" name="cover_image" class="w-full text-sm">
        @if ($hero->cover_image)
            <img src="{{ asset('storage/'.$hero->cover_image) }}" class="mt-2 h-24 rounded">
        @endif
    </div>
    <label class="flex items-center text-sm">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $hero->is_active) ? 'checked' : '' }} class="mr-2">
        Jadikan hero aktif (ditampilkan di landing page)
    </label>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.hero.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
