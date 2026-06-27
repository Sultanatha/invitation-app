@extends('admin.layouts.app')
@section('title', $story->exists ? 'Edit Cerita' : 'Tambah Cerita')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $story->exists ? route('admin.love-story.update', $story) : route('admin.love-story.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @if ($story->exists) @method('PUT') @endif

    <div><label class="block text-sm font-medium mb-1">Judul</label><input type="text" name="title" value="{{ old('title', $story->title) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
    <div><label class="block text-sm font-medium mb-1">Tanggal</label><input type="date" name="story_date" value="{{ old('story_date', $story->story_date?->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Deskripsi</label><textarea name="description" class="w-full border rounded px-3 py-2 text-sm">{{ old('description', $story->description) }}</textarea></div>
    <div><label class="block text-sm font-medium mb-1">Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $story->sort_order) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div>
        <label class="block text-sm font-medium mb-1">Foto</label>
        <input type="file" name="photo" class="w-full text-sm">
        @if ($story->photo)<img src="{{ asset('storage/'.$story->photo) }}" class="mt-2 h-24 rounded">@endif
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.love-story.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
