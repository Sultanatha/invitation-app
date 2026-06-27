@extends('admin.layouts.app')
@section('title', $gift->exists ? 'Edit Hadiah' : 'Tambah Hadiah')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-xl">
<form method="POST" action="{{ $gift->exists ? route('admin.gifts.update', $gift) : route('admin.gifts.store') }}" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @if ($gift->exists) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium mb-1">Tipe</label>
        <select name="type" class="w-full border rounded px-3 py-2 text-sm">
            <option value="bank" {{ old('type', $gift->type) == 'bank' ? 'selected' : '' }}>Rekening Bank</option>
            <option value="ewallet" {{ old('type', $gift->type) == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
            <option value="address" {{ old('type', $gift->type) == 'address' ? 'selected' : '' }}>Alamat Kado</option>
        </select>
    </div>
    <div><label class="block text-sm font-medium mb-1">Nama Provider</label><input type="text" name="provider_name" value="{{ old('provider_name', $gift->provider_name) }}" class="w-full border rounded px-3 py-2 text-sm" required placeholder="BCA / GoPay / dst"></div>
    <div><label class="block text-sm font-medium mb-1">No. Rekening / No. HP</label><input type="text" name="account_number" value="{{ old('account_number', $gift->account_number) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Nama Pemilik</label><input type="text" name="account_name" value="{{ old('account_name', $gift->account_name) }}" class="w-full border rounded px-3 py-2 text-sm"></div>
    <div><label class="block text-sm font-medium mb-1">Catatan</label><textarea name="note" class="w-full border rounded px-3 py-2 text-sm">{{ old('note', $gift->note) }}</textarea></div>
    <div>
        <label class="block text-sm font-medium mb-1">Logo</label>
        <input type="file" name="logo" class="w-full text-sm">
        @if ($gift->logo)<img src="{{ asset('storage/'.$gift->logo) }}" class="mt-2 h-16 rounded">@endif
    </div>

    <button class="bg-gray-900 text-white px-4 py-2 rounded text-sm">Simpan</button>
    <a href="{{ route('admin.gifts.index') }}" class="text-sm text-gray-500 ml-2">Batal</a>
</form>
</div>
@endsection
