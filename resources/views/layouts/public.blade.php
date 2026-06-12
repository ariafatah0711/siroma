<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SIROMA' }}</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/css/scrollbar.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-[100dvh] text-neutral-950 antialiased">
    <x-public-navbar />

    @if (session('status'))
        <div class="mx-auto mt-4 max-w-6xl border-2 border-neutral-950 bg-neutral-100 px-4 py-3 text-sm font-semibold">
            {{ session('status') }}
        </div>
    @endif

    <main class="mx-auto max-w-6xl px-4 py-10 md:py-14">
        @yield('content')
    </main>

    <x-public-footer />
</body>
</html>
