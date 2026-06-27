@extends('admin.layouts.app')
@section('title', 'Jadwal Acara')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Jadwal Acara</h2>
    @can('create-event')<a href="{{ route('admin.events.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>@endcan
</div>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Acara</th><th>Tanggal</th><th>Waktu</th><th>Lokasi</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @forelse ($events as $event)
        <tr class="border-t">
            <td class="p-3">{{ $event->title }}</td>
            <td>{{ $event->event_date->format('d M Y') }}</td>
            <td>{{ $event->start_time }} @if($event->end_time) - {{ $event->end_time }} @endif</td>
            <td>{{ $event->venue_name }}</td>
            <td class="p-3 text-right space-x-2">
                @can('update-event')<a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600">Edit</a>@endcan
                @can('delete-event')<form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>@endcan
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-4 text-center text-gray-400">Belum ada data</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
