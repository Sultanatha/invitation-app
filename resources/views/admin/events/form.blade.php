@extends('admin.layouts.app')
@section('title', $event->exists ? 'Edit Acara' : 'Tambah Acara')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}" class="space-y-4">
    @csrf
    @if ($event->exists) @method('PUT') @endif

    <div><label class="block text-sm font-medium mb-1">Judul Acara</label><input type="text" name="title" value="{{ old('title', $event->title) }}" class="w-full border rounded px-3 py-2 text-sm" required placeholder="Akad Nikah / Resepsi"></div>
    <div><label class="block text-sm font-medium mb-1">Tanggal</label><input type="date" name="event_date" value="{{ old('event_date', $event->event_date?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
    <div class="flex gap-3">
        <div class="flex-1"><label class="block text-sm font-medium mb-1">Jam Mulai</label><input type="time" name="start_time" value="{{ old('start_time', $event->start_time) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
        <div class="flex-1"><label class="block text-sm font-medium mb-1">Jam Selesai</label><input type="time" name="end_time" value="{{ old('end_time', $event->end_time) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    </div>
    <div><label class="block text-sm font-medium mb-1">Nama Tempat</label><input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
    <div><label class="block text-sm font-medium mb-1">Alamat</label><textarea name="address" class="w-full border rounded px-3 py-2 text-sm">{{ old('address', $event->address) }}</textarea></div>
    <div><label class="block text-sm font-medium mb-1">Link Google Maps</label><input type="text" name="map_url" value="{{ old('map_url', $event->map_url) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Urutan Tampil</label><input type="number" name="sort_order" value="{{ old('sort_order', $event->sort_order) }}" class="w-full border rounded px-3 py-2 text-sm"></div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
