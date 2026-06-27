@extends('admin.layouts.app')
@section('title', 'Cerita Cinta')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Cerita Cinta</h2>
    @can('create-love-story')<a href="{{ route('admin.love-story.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>@endcan
</div>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Judul</th><th>Tanggal</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @forelse ($stories as $story)
        <tr class="border-t">
            <td class="p-3">{{ $story->title }}</td>
            <td>{{ $story->story_date?->format('d M Y') }}</td>
            <td class="p-3 text-right space-x-2">
                @can('update-love-story')<a href="{{ route('admin.love-story.edit', $story) }}" class="text-blue-600">Edit</a>@endcan
                @can('delete-love-story')<form action="{{ route('admin.love-story.destroy', $story) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>@endcan
            </td>
        </tr>
        @empty
        <tr><td colspan="3" class="p-4 text-center text-gray-400">Belum ada data</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
