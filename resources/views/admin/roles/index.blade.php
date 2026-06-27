@extends('admin.layouts.app')
@section('title', 'Role & Permission')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Daftar Role</h2>
    @can('create-role')<a href="{{ route('admin.roles.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah Role</a>@endcan
</div>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Role</th><th>Jumlah Permission</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @foreach ($roles as $role)
        <tr class="border-t">
            <td class="p-3">{{ $role->name }}</td>
            <td>{{ $role->permissions->count() }}</td>
            <td class="p-3 text-right space-x-2">
                @if (!in_array($role->name, ['super-admin']))
                    @can('update-role')<a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600">Edit</a>@endcan
                @endif
                @if (!in_array($role->name, ['super-admin', 'admin']))
                    @can('delete-role')
                    <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600">Hapus</button>
                    </form>
                    @endcan
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
