@extends('admin.layouts.app')
@section('title', 'Mempelai')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Data Mempelai</h2>
    @can('create-couple')
    <a href="{{ route('admin.couple.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>
    @endcan
</div>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Role</th><th>Nama</th><th>Orang Tua</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @forelse ($couples as $couple)
        <tr class="border-t">
            <td class="p-3">{{ $couple->role }}</td>
            <td>{{ $couple->full_name }} ({{ $couple->nickname }})</td>
            <td>{{ $couple->father_name }} & {{ $couple->mother_name }}</td>
            <td class="p-3 text-right space-x-2">
                @can('update-couple')<a href="{{ route('admin.couple.edit', $couple) }}" class="text-blue-600">Edit</a>@endcan
                @can('delete-couple')
                <form action="{{ route('admin.couple.destroy', $couple) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>
                @endcan
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="p-4 text-center text-gray-400">Belum ada data</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
