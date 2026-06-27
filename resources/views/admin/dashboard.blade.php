@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
@php
    $total = max((int) $stats['total_rsvp'], 1);
    $presentPercent = round(($stats['hadir'] / $total) * 100);
    $absentPercent = round(($stats['tidak_hadir'] / $total) * 100);
    $unsurePercent = round(($stats['ragu'] / $total) * 100);
    $statCards = [
        ['label' => 'Total RSVP', 'value' => $stats['total_rsvp'], 'tone' => 'bg-ink text-white', 'hint' => 'Semua konfirmasi'],
        ['label' => 'Hadir', 'value' => $stats['hadir'], 'tone' => 'bg-emerald-50 text-emerald-700', 'hint' => $presentPercent.'% dari RSVP'],
        ['label' => 'Tidak Hadir', 'value' => $stats['tidak_hadir'], 'tone' => 'bg-red-50 text-red-700', 'hint' => $absentPercent.'% dari RSVP'],
        ['label' => 'Masih Ragu', 'value' => $stats['ragu'], 'tone' => 'bg-amber-50 text-amber-700', 'hint' => $unsurePercent.'% dari RSVP'],
    ];
@endphp

<section class="mb-6 rounded-xl border border-slate-200 bg-white p-5 shadow-panel">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wide text-blush">Ringkasan undangan</p>
            <h2 class="mt-1 text-2xl font-bold text-ink">Kelola konten dan RSVP dari satu tempat</h2>
            <p class="mt-2 max-w-2xl text-sm text-slate-500">Pantau status tamu, jadwal acara, galeri, dan modul utama undangan.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            @can('view-rsvp')
                <a href="{{ route('admin.rsvp.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-ink px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-700">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M5 4h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H8l-5 4V6a2 2 0 0 1 2-2Zm3 5v2h8V9H8Zm0 4v2h5v-2H8Z"/></svg>
                    RSVP
                </a>
            @endcan
            @can('view-setting')
                <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300">
                    <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm8 4-1.7-.6c-.1-.5-.3-1-.6-1.5l.8-1.6-2.8-2.8-1.6.8c-.5-.3-1-.5-1.5-.6L12 4H8l-.6 1.7c-.5.1-1 .3-1.5.6l-1.6-.8-2.8 2.8.8 1.6c-.3.5-.5 1-.6 1.5L0 12l.6 4 1.7.6c.1.5.3 1 .6 1.5l-.8 1.6 2.8 2.8 1.6-.8c.5.3 1 .5 1.5.6L8 24h4l.6-1.7c.5-.1 1-.3 1.5-.6l1.6.8 2.8-2.8-.8-1.6c.3-.5.5-1 .6-1.5L20 16v-4Z"/></svg>
                    Pengaturan
                </a>
            @endcan
        </div>
    </div>
</section>

<section class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($statCards as $card)
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="text-sm font-medium text-slate-500">{{ $card['label'] }}</p>
                    <p class="mt-2 text-3xl font-bold text-ink">{{ $card['value'] }}</p>
                </div>
                <span class="rounded-lg px-3 py-1 text-xs font-bold {{ $card['tone'] }}">{{ $card['hint'] }}</span>
            </div>
        </div>
    @endforeach
</section>

<section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
    <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
        <div class="flex items-center justify-between border-b border-slate-200 px-5 py-4">
            <div>
                <h2 class="font-bold text-ink">RSVP Terbaru</h2>
                <p class="text-sm text-slate-500">5 konfirmasi terakhir dari tamu.</p>
            </div>
            @can('view-rsvp')
                <a href="{{ route('admin.rsvp.index') }}" class="text-sm font-semibold text-blush hover:text-ink">Lihat semua</a>
            @endcan
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[680px] text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Nama</th>
                        <th class="px-5 py-3">Kehadiran</th>
                        <th class="px-5 py-3">Jumlah</th>
                        <th class="px-5 py-3">Pesan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($latestRsvp as $rsvp)
                        <tr class="hover:bg-slate-50">
                            <td class="px-5 py-4 font-semibold text-ink">{{ $rsvp->guest_name }}</td>
                            <td class="px-5 py-4">
                                @if($rsvp->attendance == 'hadir')
                                    <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">Hadir</span>
                                @elseif($rsvp->attendance == 'tidak_hadir')
                                    <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-bold text-red-700">Tidak hadir</span>
                                @else
                                    <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">Masih ragu</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $rsvp->total_guest }}</td>
                            <td class="max-w-sm truncate px-5 py-4 text-slate-600">{{ $rsvp->message ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-400">Belum ada RSVP</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-bold text-ink">Komposisi Kehadiran</h2>
            <div class="mt-5 space-y-4">
                <div>
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="font-medium text-slate-600">Hadir</span>
                        <span class="font-bold text-emerald-700">{{ $presentPercent }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-emerald-500" style="width: {{ $presentPercent }}%"></div></div>
                </div>
                <div>
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="font-medium text-slate-600">Tidak hadir</span>
                        <span class="font-bold text-red-700">{{ $absentPercent }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-red-500" style="width: {{ $absentPercent }}%"></div></div>
                </div>
                <div>
                    <div class="mb-1 flex justify-between text-sm">
                        <span class="font-medium text-slate-600">Masih ragu</span>
                        <span class="font-bold text-amber-700">{{ $unsurePercent }}%</span>
                    </div>
                    <div class="h-2 rounded-full bg-slate-100"><div class="h-2 rounded-full bg-amber-500" style="width: {{ $unsurePercent }}%"></div></div>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-bold text-ink">Konten Aktif</h2>
            <div class="mt-4 grid grid-cols-2 gap-3">
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Jadwal</p>
                    <p class="mt-1 text-2xl font-bold text-ink">{{ $stats['total_event'] }}</p>
                </div>
                <div class="rounded-lg bg-slate-50 p-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Galeri</p>
                    <p class="mt-1 text-2xl font-bold text-ink">{{ $stats['total_gallery'] }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
