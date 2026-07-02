<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['site_title'] ?: $invitation->title }}</title>
    <meta name="description" content="{{ $settings['site_description'] }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#151515',
                        paper: '#fffaf6',
                        accent: '{{ $settings['theme_color'] }}',
                        leaf: '#4f7f68',
                    },
                    fontFamily: {
                        display: ['Georgia', 'serif'],
                    },
                },
            },
        };
    </script>
</head>
<body class="bg-paper text-ink antialiased">
@php
    $cover = $hero?->cover_image ? asset('storage/'.$hero->cover_image) : null;
    $groom = $hero?->groom_name ?? $couples->firstWhere('role', 'groom')?->nickname ?? 'Mempelai';
    $bride = $hero?->bride_name ?? $couples->firstWhere('role', 'bride')?->nickname ?? 'Tercinta';
@endphp

<main>
    <section class="relative min-h-[92vh] overflow-hidden">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $groom }} & {{ $bride }}" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 bg-black/45"></div>
        @else
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,#f7d8d8,transparent_34%),linear-gradient(135deg,#fffaf6,#f4eee7_50%,#e8f0e9)]"></div>
        @endif

        <div class="relative z-10 flex min-h-[92vh] items-center justify-center px-6 py-16 text-center {{ $cover ? 'text-white' : 'text-ink' }}">
            <div class="max-w-3xl">
                <p class="text-sm font-semibold uppercase tracking-[0.32em]">The Wedding Of</p>
                <h1 class="mt-5 font-display text-5xl leading-tight sm:text-7xl">{{ $groom }} & {{ $bride }}</h1>
                @if ($hero?->event_date)
                    <p class="mt-5 text-lg font-medium">{{ $hero->event_date->translatedFormat('l, d F Y') }}</p>
                @endif
                @if ($hero?->opening_quote)
                    <p class="mx-auto mt-8 max-w-2xl text-base leading-8 opacity-90">{{ $hero->opening_quote }}</p>
                @endif
                <div class="mt-10 flex flex-wrap justify-center gap-3">
                    <a href="#rsvp" class="rounded-full bg-accent px-6 py-3 text-sm font-bold text-white shadow-lg shadow-black/10">Isi RSVP</a>
                    @if ($events->first()?->map_url)
                        <a href="{{ $events->first()->map_url }}" target="_blank" class="rounded-full border border-current px-6 py-3 text-sm font-bold">Lihat Lokasi</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="px-6 py-16">
        <div class="mx-auto max-w-5xl">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent">Mempelai</p>
                <h2 class="mt-3 font-display text-4xl">Dengan penuh bahagia</h2>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2">
                @forelse ($couples as $couple)
                    <article class="rounded-lg bg-white p-6 text-center shadow-sm">
                        @if ($couple->photo)
                            <img src="{{ asset('storage/'.$couple->photo) }}" alt="{{ $couple->full_name }}" class="mx-auto h-36 w-36 rounded-full object-cover">
                        @endif
                        <h3 class="mt-5 font-display text-3xl">{{ $couple->full_name }}</h3>
                        @if ($couple->child_order || $couple->father_name || $couple->mother_name)
                            <p class="mt-3 text-sm leading-7 text-slate-600">
                                {{ $couple->child_order }}<br>
                                {{ $couple->father_name ? 'Bapak '.$couple->father_name : '' }}
                                {{ $couple->father_name && $couple->mother_name ? ' & ' : '' }}
                                {{ $couple->mother_name ? 'Ibu '.$couple->mother_name : '' }}
                            </p>
                        @endif
                        @if ($couple->instagram)
                            <a href="https://instagram.com/{{ ltrim($couple->instagram, '@') }}" target="_blank" class="mt-4 inline-flex text-sm font-semibold text-accent">{{ $couple->instagram }}</a>
                        @endif
                    </article>
                @empty
                    <p class="rounded-lg bg-white p-6 text-center text-sm text-slate-500 md:col-span-2">Data mempelai belum diisi.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white px-6 py-16">
        <div class="mx-auto max-w-5xl">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent">Acara</p>
                <h2 class="mt-3 font-display text-4xl">Waktu dan tempat</h2>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-{{ $events->count() > 1 ? '2' : '1' }}">
                @forelse ($events as $event)
                    <article class="rounded-lg border border-slate-200 p-6 text-center">
                        <h3 class="font-display text-3xl">{{ $event->title }}</h3>
                        <p class="mt-4 font-semibold">{{ $event->event_date->translatedFormat('d F Y') }}</p>
                        <p class="mt-1 text-sm text-slate-600">{{ substr($event->start_time, 0, 5) }}{{ $event->end_time ? ' - '.substr($event->end_time, 0, 5) : '' }}</p>
                        <p class="mt-4 font-semibold">{{ $event->venue_name }}</p>
                        @if ($event->address)
                            <p class="mt-2 text-sm leading-7 text-slate-600">{{ $event->address }}</p>
                        @endif
                        @if ($event->map_url)
                            <a href="{{ $event->map_url }}" target="_blank" class="mt-5 inline-flex rounded-full bg-ink px-5 py-2 text-sm font-semibold text-white">Buka Maps</a>
                        @endif
                    </article>
                @empty
                    <p class="rounded-lg border border-dashed border-slate-300 p-6 text-center text-sm text-slate-500">Jadwal acara belum diisi.</p>
                @endforelse
            </div>
        </div>
    </section>

    @if ($loveStories->isNotEmpty())
    <section class="px-6 py-16">
        <div class="mx-auto max-w-3xl">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent">Cerita</p>
                <h2 class="mt-3 font-display text-4xl">Perjalanan kami</h2>
            </div>
            <div class="mt-10 space-y-5">
                @foreach ($loveStories as $story)
                    <article class="rounded-lg bg-white p-5 shadow-sm">
                        <p class="text-xs font-semibold uppercase tracking-wide text-accent">{{ $story->story_date?->translatedFormat('d F Y') }}</p>
                        <h3 class="mt-2 text-lg font-bold">{{ $story->title }}</h3>
                        <p class="mt-2 text-sm leading-7 text-slate-600">{{ $story->description }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($galleries->isNotEmpty())
    <section class="bg-white px-6 py-16">
        <div class="mx-auto max-w-6xl">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent">Galeri</p>
                <h2 class="mt-3 font-display text-4xl">Momen pilihan</h2>
            </div>
            <div class="mt-10 grid grid-cols-2 gap-3 md:grid-cols-4">
                @foreach ($galleries as $gallery)
                    <figure class="overflow-hidden rounded-lg bg-slate-100">
                        <img src="{{ asset('storage/'.$gallery->image) }}" alt="{{ $gallery->caption ?: 'Galeri undangan' }}" class="aspect-square h-full w-full object-cover">
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @if ($gifts->isNotEmpty())
    <section class="px-6 py-16">
        <div class="mx-auto max-w-4xl text-center">
            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent">Hadiah</p>
            <h2 class="mt-3 font-display text-4xl">Wedding gift</h2>
            <div class="mt-10 grid gap-4 md:grid-cols-2">
                @foreach ($gifts as $gift)
                    <article class="rounded-lg bg-white p-5 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-wide text-slate-400">{{ $gift->provider_name }}</p>
                        @if ($gift->account_number)
                            <p class="mt-3 text-xl font-bold">{{ $gift->account_number }}</p>
                        @endif
                        @if ($gift->account_name)
                            <p class="mt-1 text-sm text-slate-600">a.n. {{ $gift->account_name }}</p>
                        @endif
                        @if ($gift->note)
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $gift->note }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section id="rsvp" class="bg-ink px-6 py-16 text-white">
        <div class="mx-auto max-w-xl">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-white/60">RSVP</p>
                <h2 class="mt-3 font-display text-4xl">Konfirmasi kehadiran</h2>
            </div>
            <form id="rsvpForm" class="mt-8 space-y-4 rounded-lg bg-white p-5 text-ink">
                <input type="text" name="guest_name" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Nama tamu" required>
                <select name="attendance" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <option value="hadir">Hadir</option>
                    <option value="tidak_hadir">Tidak hadir</option>
                    <option value="masih_ragu">Masih ragu</option>
                </select>
                <input type="number" name="total_guest" min="1" max="10" value="1" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" placeholder="Jumlah tamu">
                <textarea name="message" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm" rows="4" placeholder="Ucapan atau pesan"></textarea>
                <button class="w-full rounded-lg bg-accent px-4 py-3 text-sm font-bold text-white">Kirim RSVP</button>
                <p id="rsvpStatus" class="hidden text-center text-sm font-semibold"></p>
            </form>
        </div>
    </section>
</main>

<script>
    document.getElementById('rsvpForm').addEventListener('submit', async function (event) {
        event.preventDefault();

        const form = event.currentTarget;
        const status = document.getElementById('rsvpStatus');
        const data = Object.fromEntries(new FormData(form).entries());
        data.total_guest = Number(data.total_guest || 1);

        status.className = 'text-center text-sm font-semibold text-slate-500';
        status.textContent = 'Mengirim RSVP...';

        const response = await fetch('/api/v1/invitations/{{ $invitation->slug }}/rsvp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            form.reset();
            status.className = 'text-center text-sm font-semibold text-emerald-700';
            status.textContent = 'Terima kasih, RSVP berhasil dikirim.';
            return;
        }

        status.className = 'text-center text-sm font-semibold text-red-700';
        status.textContent = 'RSVP belum berhasil dikirim. Cek isian lalu coba lagi.';
    });
</script>
</body>
</html>
