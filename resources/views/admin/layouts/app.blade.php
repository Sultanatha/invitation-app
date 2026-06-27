<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Invitation Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#111827',
                        mist: '#f6f7fb',
                        blush: '#be3455',
                        sage: '#4f7f68',
                    },
                    boxShadow: {
                        panel: '0 18px 60px rgba(17, 24, 39, 0.08)',
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-mist text-slate-800 antialiased">
@php
    $navItems = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'permission' => null, 'icon' => 'M4 13h6V4H4v9Zm0 7h6v-5H4v5Zm10 0h6v-9h-6v9Zm0-11h6V4h-6v5Z'],
        ['label' => 'Hero Section', 'route' => 'admin.hero.index', 'match' => 'admin.hero.*', 'permission' => 'view-hero', 'icon' => 'M12 3 3 9l9 6 9-6-9-6Zm-7 9.2v4.6L12 21l7-4.2v-4.6l-7 4.2-7-4.2Z'],
        ['label' => 'Mempelai', 'route' => 'admin.couple.index', 'match' => 'admin.couple.*', 'permission' => 'view-couple', 'icon' => 'M7.5 11a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm9 0a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7ZM2 20a5.5 5.5 0 0 1 11 0H2Zm9 0a5.5 5.5 0 0 1 11 0h-5.8a7.4 7.4 0 0 0-5.2-4.7V20Z'],
        ['label' => 'Jadwal Acara', 'route' => 'admin.events.index', 'match' => 'admin.events.*', 'permission' => 'view-event', 'icon' => 'M7 2v3H5a2 2 0 0 0-2 2v2h18V7a2 2 0 0 0-2-2h-2V2h-2v3H9V2H7Zm14 9H3v8a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-8Z'],
        ['label' => 'Cerita Cinta', 'route' => 'admin.love-story.index', 'match' => 'admin.love-story.*', 'permission' => 'view-love-story', 'icon' => 'M12 21s-7-4.6-9.3-9.4C.8 7.8 3.1 4 6.9 4c2 0 3.3 1 4.1 2.1C11.8 5 13.1 4 15.1 4c3.8 0 6.1 3.8 4.2 7.6C19 16.4 12 21 12 21Z'],
        ['label' => 'Galeri', 'route' => 'admin.gallery.index', 'match' => 'admin.gallery.*', 'permission' => 'view-gallery', 'icon' => 'M4 5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14H4V5Zm2 12h12l-4.1-5.4-3.2 4-2-2.4L6 17Zm2-7a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z'],
        ['label' => 'Hadiah', 'route' => 'admin.gifts.index', 'match' => 'admin.gifts.*', 'permission' => 'view-gift', 'icon' => 'M20 7h-2.2A3 3 0 0 0 12 5.8 3 3 0 0 0 6.2 7H4a2 2 0 0 0-2 2v3h20V9a2 2 0 0 0-2-2ZM4 14v6h7v-6H4Zm9 0v6h7v-6h-7Z'],
        ['label' => 'RSVP Tamu', 'route' => 'admin.rsvp.index', 'match' => 'admin.rsvp.*', 'permission' => 'view-rsvp', 'icon' => 'M5 4h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H8l-5 4V6a2 2 0 0 1 2-2Zm3 5v2h8V9H8Zm0 4v2h5v-2H8Z'],
        ['label' => 'Pengaturan', 'route' => 'admin.settings.index', 'match' => 'admin.settings.*', 'permission' => 'view-setting', 'icon' => 'M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm9 4-2.1-.8a7 7 0 0 0-.6-1.5l.9-2-2.9-2.9-2 .9c-.5-.3-1-.5-1.5-.6L12 3H8l-.8 2.1c-.5.1-1 .3-1.5.6l-2-.9L.8 7.7l.9 2c-.3.5-.5 1-.6 1.5L-1 12l.8 4 2.1.8c.1.5.3 1 .6 1.5l-.9 2 2.9 2.9 2-.9c.5.3 1 .5 1.5.6L8 25h4l.8-2.1c.5-.1 1-.3 1.5-.6l2 .9 2.9-2.9-.9-2c.3-.5.5-1 .6-1.5L21 16v-4Z'],
    ];
    $adminItems = [
        ['label' => 'Manajemen User', 'route' => 'admin.users.index', 'match' => 'admin.users.*', 'permission' => 'view-user', 'icon' => 'M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm-8 9a8 8 0 0 1 16 0H4Z'],
        ['label' => 'Role & Permission', 'route' => 'admin.roles.index', 'match' => 'admin.roles.*', 'permission' => 'view-role', 'icon' => 'M12 2 4 5v6c0 5 3.4 9.7 8 11 4.6-1.3 8-6 8-11V5l-8-3Zm-1 14-3-3 1.4-1.4 1.6 1.6 4.6-4.6L17 10l-6 6Z'],
    ];
    $renderNav = function ($items) {
        foreach ($items as $item) {
            if ($item['permission'] && ! Gate::allows($item['permission'])) {
                continue;
            }

            $active = request()->routeIs($item['match']);
            echo '<a href="'.route($item['route']).'" class="group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition '.($active ? 'bg-ink text-white shadow-sm' : 'text-slate-600 hover:bg-white hover:text-ink').'">';
            echo '<svg viewBox="0 0 24 24" class="h-4 w-4 shrink-0 '.($active ? 'fill-white' : 'fill-slate-400 group-hover:fill-blush').'"><path d="'.$item['icon'].'"/></svg>';
            echo '<span>'.$item['label'].'</span>';
            echo '</a>';
        }
    };
@endphp

<div class="min-h-screen lg:flex">
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 -translate-x-full border-r border-slate-200 bg-white/95 px-4 py-5 shadow-panel backdrop-blur transition-transform duration-200 lg:static lg:translate-x-0 lg:shadow-none">
        <div class="flex items-center justify-between px-2">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-lg bg-ink text-sm font-bold text-white">IA</span>
                <span>
                    <span class="block text-sm font-bold text-ink">Invitation Admin</span>
                    <span class="block text-xs text-slate-500">Content dashboard</span>
                </span>
            </a>
            <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 lg:hidden" onclick="toggleSidebar(false)" aria-label="Tutup menu">
                <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current"><path d="m6.4 5 12.6 12.6-1.4 1.4L5 6.4 6.4 5Zm11.2 0L19 6.4 6.4 19 5 17.6 17.6 5Z"/></svg>
            </button>
        </div>

        <nav class="mt-8 space-y-1">
            {!! $renderNav($navItems) !!}
        </nav>

        <div class="my-5 h-px bg-slate-200"></div>

        <nav class="space-y-1">
            <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wide text-slate-400">Administrasi</p>
            {!! $renderNav($adminItems) !!}
        </nav>
    </aside>

    <div id="sidebarBackdrop" class="fixed inset-0 z-30 hidden bg-ink/40 lg:hidden" onclick="toggleSidebar(false)"></div>

    <div class="min-w-0 flex-1">
        <header class="sticky top-0 z-20 border-b border-slate-200 bg-mist/90 backdrop-blur">
            <div class="flex items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" class="rounded-lg border border-slate-200 bg-white p-2 text-slate-600 shadow-sm lg:hidden" onclick="toggleSidebar(true)" aria-label="Buka menu">
                        <svg viewBox="0 0 24 24" class="h-5 w-5 fill-current"><path d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z"/></svg>
                    </button>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">Admin Panel</p>
                        <h1 class="truncate text-xl font-bold text-ink">@yield('title', 'Dashboard')</h1>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.logout') }}" class="flex items-center gap-3">
                    @csrf
                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-semibold text-ink">{{ auth()->user()->name }}</p>
                        <p class="max-w-48 truncate text-xs text-slate-500">{{ auth()->user()->roles->pluck('name')->join(', ') }}</p>
                    </div>
                    <button class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-700">
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M10 3h9a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-9v-2h9V5h-9V3Zm1.6 5.4L13 7l5 5-5 5-1.4-1.4 2.6-2.6H3v-2h11.2l-2.6-2.6Z"/></svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    function toggleSidebar(show) {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        sidebar.classList.toggle('-translate-x-full', !show);
        backdrop.classList.toggle('hidden', !show);
    }
</script>
</body>
</html>
