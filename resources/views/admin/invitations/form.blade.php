@extends('admin.layouts.app')
@section('title', $invitation->exists ? 'Edit Undangan' : 'Tambah Undangan')

@section('content')
<div class="max-w-2xl rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
    <form method="POST" action="{{ $invitation->exists ? route('admin.invitations.update', $invitation) : route('admin.invitations.store') }}" class="space-y-5">
        @csrf
        @if ($invitation->exists) @method('PUT') @endif

        <div>
            <label class="mb-1 block text-sm font-semibold text-slate-700">Judul Undangan</label>
            <input type="text" name="title" value="{{ old('title', $invitation->title) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-ink focus:outline-none" placeholder="Undangan Budi & Siti" required>
            @error('title') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-slate-700">Slug URL</label>
            <input type="text" name="slug" value="{{ old('slug', $invitation->slug) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-ink focus:outline-none" placeholder="budi-siti">
            <p class="mt-1 text-xs text-slate-500">Kosongkan untuk dibuat otomatis dari judul. Isi hanya slug, contoh: budi-siti.</p>
            @error('slug') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-slate-700">Frontend URL</label>
            <input type="url" name="frontend_url" value="{{ old('frontend_url', $invitation->frontend_url) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-ink focus:outline-none" placeholder="https://frontend-kamu.com">
            <p class="mt-1 text-xs text-slate-500">Opsional. Isi domain FE utama, contoh https://frontend-kamu.com. Preview otomatis menambahkan slug. Jika kosong, preview memakai halaman lokal /{{ $invitation->slug ?: 'slug-undangan' }}.</p>
            @error('frontend_url') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-semibold text-slate-700">Template</label>
            <select name="template_key" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-ink focus:outline-none" required>
                @foreach (['default' => 'Default', 'classic' => 'Classic', 'modern' => 'Modern', 'floral' => 'Floral'] as $key => $label)
                    <option value="{{ $key }}" @selected(old('template_key', $invitation->template_key ?: 'default') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @error('template_key') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $invitation->exists ? $invitation->is_active : true)) class="rounded border-slate-300">
            Publikasikan halaman undangan
        </label>

        <div class="flex items-center gap-3">
            <button class="rounded-lg bg-ink px-4 py-2 text-sm font-semibold text-white">Simpan</button>
            <a href="{{ route('admin.invitations.index') }}" class="text-sm font-semibold text-slate-500 hover:text-ink">Batal</a>
        </div>
    </form>
</div>
@endsection
