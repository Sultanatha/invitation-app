@extends('admin.layouts.app')
@section('title', $gallery->exists ? 'Edit Foto' : 'Tambah Foto')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $gallery->exists ? route('admin.gallery.update', $gallery) : route('admin.gallery.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @if ($gallery->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium mb-1">Foto</label>
        <input type="file" name="image" class="w-full text-sm" {{ $gallery->exists ? '' : 'required' }}>
        @if ($gallery->image)<img src="{{ asset('storage/'.$gallery->image) }}" class="mt-2 h-24 rounded">@endif
    </div>
    <div><label class="block text-sm font-medium mb-1">Caption</label><input type="text" name="caption" value="{{ old('caption', $gallery->caption) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" class="w-full border rounded px-3 py-2 text-sm"></div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.gallery.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
