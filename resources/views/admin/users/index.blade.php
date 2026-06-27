@extends('admin.layouts.app')
@section('title', 'Manajemen User')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Daftar User Admin</h2>
    @can('create-user')<a href="{{ route('admin.users.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>@endcan
</div>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Nama</th><th>Email</th><th>Role</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @forelse ($users as $user)
        <tr class="border-t">
            <td class="p-3">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @foreach ($user->roles as $role)
                    <span class="bg-gray-200 text-xs px-2 py-1 rounded">{{ $role->name }}</span>
                @endforeach
            </td>
            <td class="p-3 text-right space-x-2">
                @can('update-user')<a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Edit</a>@endcan
                @can('delete-user')
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">
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
{{ $users->links() }}
@endsection
