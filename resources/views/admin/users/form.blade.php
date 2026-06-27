@extends('admin.layouts.app')
@section('title', $user->exists ? 'Edit User' : 'Tambah User')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="space-y-4">
    @csrf
    @if ($user->exists) @method('PUT') @endif

    <div><label class="block text-sm font-medium mb-1">Nama</label><input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
    <div><label class="block text-sm font-medium mb-1">Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2 text-sm" required></div>
    <div>
        <label class="block text-sm font-medium mb-1">Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2 text-sm" {{ $user->exists ? '' : 'required' }}>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Role</label>
        @php $userRoles = $user->roles->pluck('name')->toArray(); @endphp
        @foreach ($roles as $role)
        <label class="flex items-center text-sm mb-1">
            <input type="checkbox" name="roles[]" value="{{ $role->name }}" {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }} class="mr-2">
            {{ $role->name }}
        </label>
        @endforeach
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
