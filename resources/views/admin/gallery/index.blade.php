@extends('admin.layouts.app')
@section('title', 'Galeri')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Galeri Foto</h2>
    @can('create-gallery')<a href="{{ route('admin.gallery.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>@endcan
</div>
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @forelse ($galleries as $gallery)
    <div class="bg-white rounded shadow overflow-hidden">
        <img src="{{ asset('storage/'.$gallery->image) }}" class="w-full h-32 object-cover">
        <div class="p-3">
            <p class="text-sm truncate">{{ $gallery->caption ?? '-' }}</p>
            <div class="flex justify-between mt-2 text-sm">
                @can('update-gallery')<a href="{{ route('admin.gallery.edit', $gallery) }}" class="text-blue-600">Edit</a>@endcan
                @can('delete-gallery')
                <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Hapus?')">
                    @csrf @method('DELETE')
                    <button class="text-red-600">Hapus</button>
                </form>
                @endcan
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-400 col-span-4 text-center py-8">Belum ada foto</p>
    @endforelse
</div>
@endsection
