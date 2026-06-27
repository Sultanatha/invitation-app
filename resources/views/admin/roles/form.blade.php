@extends('admin.layouts.app')
@section('title', $role->exists ? 'Edit Role' : 'Tambah Role')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-2xl">
<form method="POST" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}" class="space-y-4">
    @csrf
    @if ($role->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium mb-1">Nama Role</label>
        <input type="text" name="name" value="{{ old('name', $role->name) }}" class="w-full border rounded px-3 py-2 text-sm" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Permission</label>
        <div class="grid grid-cols-2 gap-4">
            @foreach ($permissions as $module => $perms)
            <div class="border rounded p-3">
                <p class="text-xs font-semibold uppercase text-gray-500 mb-2">{{ $module }}</p>
                @foreach ($perms as $perm)
                <label class="flex items-center text-sm mb-1">
                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }} class="mr-2">
                    {{ $perm->name }}
                </label>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.roles.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
