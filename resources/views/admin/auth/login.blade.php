<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Invitation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink: '#111827',
                        mist: '#f6f7fb',
                        blush: '#be3455',
                    },
                    boxShadow: {
                        panel: '0 24px 70px rgba(17, 24, 39, 0.10)',
                    },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-mist text-slate-800 antialiased">
    <main class="flex min-h-screen items-center justify-center px-5 py-10">
        <section class="w-full max-w-md">
            <div class="mb-6 text-center">
                <div class="mx-auto mb-4 grid h-12 w-12 place-items-center rounded-lg bg-ink text-sm font-bold text-white">IA</div>
                <p class="text-sm font-semibold uppercase tracking-wide text-blush">Invitation Admin</p>
                <h1 class="mt-2 text-2xl font-bold text-ink">Masuk ke dashboard</h1>
                <p class="mt-2 text-sm text-slate-500">Gunakan akun admin yang sudah memiliki role.</p>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-panel">
                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-medium text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-ink focus:ring-4 focus:ring-slate-100">
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                        <input type="password" name="password" required
                               class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-ink focus:ring-4 focus:ring-slate-100">
                    </div>
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-600">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-ink focus:ring-ink">
                        Ingat saya
                    </label>
                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-ink px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-700">
                        <span>Masuk</span>
                        <svg viewBox="0 0 24 24" class="h-4 w-4 fill-current"><path d="M13 5 20 12l-7 7-1.4-1.4 4.6-4.6H4v-2h12.2l-4.6-4.6L13 5Z"/></svg>
                    </button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
