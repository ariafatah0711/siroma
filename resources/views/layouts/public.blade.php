<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SIROMA' }}</title>
    @php
        $manifestPath = public_path('build/manifest.json');
        $viteFiles = ['resources/css/app.css', 'resources/css/scrollbar.css', 'resources/js/app.js'];
        if (file_exists($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $resolvedFiles = [];
            foreach ($viteFiles as $file) {
                // Find matching key ending with our target file path
                $matchedKey = null;
                foreach (array_keys($manifest) as $key) {
                    if (str_ends_with(str_replace('\\', '/', $key), $file)) {
                        $matchedKey = $key;
                        break;
                    }
                }
                $resolvedFiles[] = $matchedKey ?: $file;
            }
        } else {
            $resolvedFiles = $viteFiles;
        }
    @endphp
    @vite($resolvedFiles)
</head>
<body class="min-h-[100dvh] text-neutral-950 antialiased">
    <x-public-navbar />

    <main class="mx-auto max-w-6xl px-4 py-10 md:py-14">
        @yield('content')
    </main>

    <x-public-footer />
</body>
</html>
