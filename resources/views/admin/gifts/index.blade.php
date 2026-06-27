@extends('admin.layouts.app')
@section('title', 'Hadiah')

@section('content')
<div class="flex justify-between mb-4">
    <h2 class="font-semibold">Info Hadiah / Rekening</h2>
    @can('create-gift')<a href="{{ route('admin.gifts.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded text-sm">+ Tambah</a>@endcan
</div>
<div class="bg-white rounded shadow overflow-hidden">
<table class="w-full text-sm">
    <thead class="bg-gray-50"><tr class="text-left"><th class="p-3">Tipe</th><th>Provider</th><th>No. Rekening</th><th>Nama</th><th class="text-right p-3">Aksi</th></tr></thead>
    <tbody>
        @forelse ($gifts as $gift)
        <tr class="border-t">
            <td class="p-3">{{ $gift->type }}</td>
            <td>{{ $gift->provider_name }}</td>
            <td>{{ $gift->account_number }}</td>
            <td>{{ $gift->account_name }}</td>
            <td class="p-3 text-right space-x-2">
                @can('update-gift')<a href="{{ route('admin.gifts.edit', $gift) }}" class="text-blue-600">Edit</a>@endcan
                @can('delete-gift')<form action="{{ route('admin.gifts.destroy', $gift) }}" method="POST" class="inline" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')<button class="text-red-600">Hapus</button></form>@endcan
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="p-4 text-center text-gray-400">Belum ada data</td></tr>
        @endforelse
    </tbody>
</table>
</div>
@endsection
