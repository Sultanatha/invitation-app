@extends('admin.layouts.app')
@section('title', 'Hero Section')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Daftar Hero Section</h2>
    @can('create-hero')
    <a href="{{ route('admin.hero.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>
    @endcan
</div>

<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50">
        <tr class="text-left">
            <th class="p-3">Mempelai</th>
            <th>Tanggal</th>
            <th>Aktif</th>
            <th class="text-right p-3">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($heroes as $hero)
        <tr class="border-t">
            <td class="p-3">{{ $hero->groom_name }} & {{ $hero->bride_name }}</td>
            <td>{{ $hero->event_date->format('d M Y') }}</td>
            <td>{{ $hero->is_active ? 'Ya' : 'Tidak' }}</td>
            <td class="p-3 text-right space-x-2">
                @can('update-hero')
                <a href="{{ route('admin.hero.edit', $hero) }}" class="text-blue-600">Edit</a>
                @endcan
                @can('delete-hero')
                <form action="{{ route('admin.hero.destroy', $hero) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
                @endcan
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="p-4 text-center text-gray-400">Belum ada data</td></tr>
        @endforelse
    </tbody>
</table>
</div>
{{ $heroes->links() }}
@endsection
