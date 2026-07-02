@extends('admin.layouts.app')
@section('title', 'Undangan')

@section('content')
<div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h2 class="text-lg font-bold text-ink">Daftar Undangan</h2>
        <p class="text-sm text-slate-500">Klik Kelola untuk menentukan undangan aktif di dashboard dan semua modul konten. Preview membuka tampilan FE berdasarkan slug.</p>
    </div>
    @can('create-invitation')
    <a href="{{ route('admin.invitations.create') }}" class="inline-flex items-center justify-center rounded-lg bg-ink px-4 py-2 text-sm font-semibold text-white">+ Tambah Undangan</a>
    @endcan
</div>

<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    @forelse ($invitations as $invitation)
        <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h3 class="truncate text-base font-bold text-ink">{{ $invitation->title }}</h3>
                    <p class="mt-1 text-sm text-slate-500">/{{ $invitation->slug }}</p>
                    <p class="mt-1 truncate text-xs text-slate-400">{{ $invitation->frontend_url ? 'FE: '.$invitation->public_url : 'Lokal: '.$invitation->public_url }}</p>
                </div>
                @if ($currentInvitation->is($invitation))
                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Aktif dikelola</span>
                @endif
            </div>

            <dl class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Template</dt>
                    <dd class="mt-1 font-medium text-slate-700">{{ $invitation->template_key }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase tracking-wide text-slate-400">Status</dt>
                    <dd class="mt-1 font-medium {{ $invitation->is_active ? 'text-emerald-700' : 'text-slate-500' }}">{{ $invitation->is_active ? 'Publik' : 'Nonaktif' }}</dd>
                </div>
            </dl>

            <div class="mt-5 flex flex-wrap items-center gap-2">
                @can('view-invitation')
                <form method="POST" action="{{ route('admin.invitations.switch', $invitation) }}">
                    @csrf
                    <button class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-ink hover:text-ink">Kelola</button>
                </form>
                @endcan
                <a href="{{ $invitation->public_url }}" target="_blank" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-blush hover:text-blush">Preview</a>
                @can('update-invitation')
                <a href="{{ route('admin.invitations.edit', $invitation) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 hover:border-blue-300 hover:text-blue-700">Edit</a>
                @endcan
                @can('delete-invitation')
                <form method="POST" action="{{ route('admin.invitations.destroy', $invitation) }}" onsubmit="return confirm('Hapus undangan ini beserta semua kontennya?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg border border-red-200 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Hapus</button>
                </form>
                @endcan
            </div>
        </div>
    @empty
        <div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center text-sm text-slate-500 md:col-span-2 xl:col-span-3">
            Belum ada undangan.
        </div>
    @endforelse
</div>

<div class="mt-5">{{ $invitations->links() }}</div>
@endsection
