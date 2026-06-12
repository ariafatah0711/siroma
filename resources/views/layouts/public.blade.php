<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SIROMA' }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-white text-neutral-950 antialiased">
    <header class="border-b-2 border-neutral-950">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="font-bold tracking-tight">SIROMA</a>
            <div class="flex items-center gap-4 text-sm font-semibold">
                <a href="{{ route('organizations.index') }}" class="hover:underline">Organisasi</a>
                <a href="{{ route('recruitments.index') }}" class="hover:underline">Rekrutmen</a>
                <a href="{{ url('/admin') }}" class="rounded border-2 border-neutral-950 px-3 py-1 hover:bg-neutral-950 hover:text-white">Admin</a>
            </div>
        </nav>
    </header>

    @if (session('status'))
        <div class="mx-auto mt-4 max-w-6xl border-2 border-neutral-950 bg-neutral-100 px-4 py-3 text-sm font-semibold">
            {{ session('status') }}
        </div>
    @endif

    <main class="mx-auto max-w-6xl px-4 py-10">
        @yield('content')
    </main>

    <footer class="border-t-2 border-neutral-950 px-4 py-6 text-center text-sm">
        &copy; 2026 SIROMA. Sistem Informasi Rekrutmen Organisasi Mahasiswa.
    </footer>
</body>
</html>
