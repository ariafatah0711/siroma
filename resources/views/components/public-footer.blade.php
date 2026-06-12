<footer class="mt-16 border-t-3 border-neutral-950 bg-white">
    <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 md:grid-cols-[1.2fr_0.8fr_0.8fr]">
        <div>
            <p class="text-2xl font-black">SIROMA</p>
            <p class="mt-3 max-w-md text-sm leading-6 text-neutral-700">Sistem Informasi Rekrutmen Organisasi Mahasiswa untuk melihat periode rekrutmen, memilih divisi, dan memantau status pendaftaran.</p>
        </div>
        <div>
            <p class="font-black">Navigasi</p>
            <div class="mt-3 grid gap-2 text-sm font-semibold">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
                <a href="{{ route('organizations.index') }}" class="hover:underline">Organisasi</a>
                <a href="{{ route('recruitments.index') }}" class="hover:underline">Rekrutmen</a>
            </div>
        </div>
        <div>
            <p class="font-black">Panel</p>
            <div class="mt-3 grid gap-2 text-sm font-semibold">
                <a href="{{ url('/admin') }}" class="hover:underline">Admin Filament</a>
                <span class="text-neutral-600">Copyright 2026</span>
            </div>
        </div>
    </div>
</footer>
