@extends('admin.layouts.app')
@section('title', $couple->exists ? 'Edit Mempelai' : 'Tambah Mempelai')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $couple->exists ? route('admin.couple.update', $couple) : route('admin.couple.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @if ($couple->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium mb-1">Role</label>
        <select name="role" class="w-full border rounded px-3 py-2 text-sm">
            <option value="groom" {{ old('role', $couple->role) == 'groom' ? 'selected' : '' }}>Mempelai Pria</option>
            <option value="bride" {{ old('role', $couple->role) == 'bride' ? 'selected' : '' }}>Mempelai Wanita</option>
        </select>
    </div>
    <div><label class="block text-sm font-medium mb-1">Nama Lengkap</label><input type="text" name="full_name" value="{{ old('full_name', $couple->full_name) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
    <div><label class="block text-sm font-medium mb-1">Nama Panggilan</label><input type="text" name="nickname" value="{{ old('nickname', $couple->nickname) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Anak ke-</label><input type="text" name="child_order" value="{{ old('child_order', $couple->child_order) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Nama Ayah</label><input type="text" name="father_name" value="{{ old('father_name', $couple->father_name) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Nama Ibu</label><input type="text" name="mother_name" value="{{ old('mother_name', $couple->mother_name) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Bio</label><textarea name="bio" class="w-full border rounded px-3 py-2 text-sm">{{ old('bio', $couple->bio) }}</textarea></div>
    <div><label class="block text-sm font-medium mb-1">Instagram</label><input type="text" name="instagram" value="{{ old('instagram', $couple->instagram) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div>
        <label class="block text-sm font-medium mb-1">Foto</label>
        <input type="file" name="photo" class="w-full text-sm">
        @if ($couple->photo)<img src="{{ asset('storage/'.$couple->photo) }}" class="mt-2 h-24 rounded">@endif
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.couple.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
