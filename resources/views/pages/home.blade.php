@extends('layouts.public', ['title' => 'SIROMA - Rekrutmen Organisasi Mahasiswa'])

@section('content')
    <section class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
        <div class="relative">
            <div class="screentone absolute -left-6 -top-6 -z-10 h-32 w-32 rounded-full opacity-70"></div>
            <p class="burst-label mb-5">SIROMA</p>
            <h1 class="text-5xl font-black leading-[0.9] tracking-tight md:text-7xl">Satu jalur buat masuk organisasi kampus.</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-neutral-700">Cari rekrutmen yang sedang dibuka, pilih divisi, upload CV, lalu pantau status seleksi dari akun mahasiswa kamu sendiri.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <x-ink-button :href="route('recruitments.index')">Mulai Daftar</x-ink-button>
            </div>
            <div class="mt-8 grid max-w-2xl gap-3 sm:grid-cols-3">
                <div class="border-l-4 border-neutral-950 pl-3">
                    <p class="text-2xl font-black">01</p>
                    <p class="text-sm font-bold text-neutral-700">Cek periode aktif</p>
                </div>
                <div class="border-l-4 border-neutral-950 pl-3">
                    <p class="text-2xl font-black">02</p>
                    <p class="text-sm font-bold text-neutral-700">Pilih divisi</p>
                </div>
                <div class="border-l-4 border-neutral-950 pl-3">
                    <p class="text-2xl font-black">03</p>
                    <p class="text-sm font-bold text-neutral-700">Upload CV</p>
                </div>
            </div>
        </div>

        <div class="grid gap-5">
            <x-comic-panel class="relative overflow-hidden p-6">
                <div class="speed-lines absolute inset-0 opacity-20"></div>
                <div class="relative">
                    <p class="font-mono text-sm font-black uppercase tracking-[0.2em]">PANEL PENDAFTARAN</p>
                    <h2 class="mt-3 text-4xl font-black leading-none">Daftar, cek, lanjut seleksi.</h2>
                    <p class="mt-3 max-w-sm text-sm leading-6 text-neutral-700">Semua aplikasi terhubung ke akun login. Tidak perlu pilih nama manual lagi.</p>
                    <div class="mt-5 grid gap-3 sm:grid-cols-2">
                        <div class="comic-panel-soft bg-white p-4">
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">Wajib</p>
                            <p class="mt-1 text-xl font-black">Login + CV</p>
                        </div>
                        <div class="comic-panel-soft bg-white p-4">
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">Output</p>
                            <p class="mt-1 text-xl font-black">Kode & riwayat status</p>
                        </div>
                    </div>
                </div>
            </x-comic-panel>
            <dl class="grid grid-cols-2 gap-4">
                @foreach ($stats as $label => $value)
                    <x-stat-card :label="str($label)->headline()" :value="$value" />
                @endforeach
            </dl>
        </div>
    </section>

    <section class="mt-24">
        <x-section-heading eyebrow="How It Works" title="Cara daftar tanpa drama" description="Alurnya dibuat pendek supaya mahasiswa fokus ke pilihan divisi, motivasi, dan berkas CV." class="text-center" />
        <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            <x-comic-panel soft class="p-6">
                <p class="text-5xl font-black">01</p>
                <h3 class="mt-4 text-2xl font-black">Cari rekrutmen</h3>
                <p class="mt-3 text-sm leading-6 text-neutral-700">Buka daftar rekrutmen, filter organisasi, lalu cek status periode yang masih menerima pendaftaran.</p>
            </x-comic-panel>
            <x-comic-panel soft class="p-6 lg:translate-y-8">
                <p class="text-5xl font-black">02</p>
                <h3 class="mt-4 text-2xl font-black">Pilih divisi</h3>
                <p class="mt-3 text-sm leading-6 text-neutral-700">Lihat divisi aktif, pilih prioritas pertama, dan tambahkan pilihan kedua kalau diperlukan.</p>
            </x-comic-panel>
            <x-comic-panel soft class="p-6">
                <p class="text-5xl font-black">03</p>
                <h3 class="mt-4 text-2xl font-black">Upload CV</h3>
                <p class="mt-3 text-sm leading-6 text-neutral-700">Lampirkan CV format PDF, DOC, atau DOCX agar reviewer punya bahan seleksi awal.</p>
            </x-comic-panel>
            <x-comic-panel soft class="p-6 lg:translate-y-8">
                <p class="text-5xl font-black">04</p>
                <h3 class="mt-4 text-2xl font-black">Wawancara & Hasil</h3>
                <p class="mt-3 text-sm leading-6 text-neutral-700">Setelah berkas dinyatakan lolos, kamu akan dihubungi untuk wawancara dan dapat memantau status akhir kelulusan.</p>
            </x-comic-panel>
        </div>
    </section>

    <section class="mt-20">
        <x-section-heading eyebrow="Now Open" title="Rekrutmen aktif" description="Pilih periode yang masih dibuka dan cek detail organisasi sebelum mengirim pendaftaran." class="text-center" />
        <div class="mt-6 grid gap-4 md:grid-cols-3">
            @forelse ($activeRecruitments as $period)
                <x-recruitment-card :period="$period" />
            @empty
                <p>Belum ada rekrutmen aktif.</p>
            @endforelse
        </div>
    </section>

    <section class="mt-24 grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
        <x-section-heading eyebrow="FAQ" title="Pertanyaan cepat" description="Beberapa hal yang biasanya dicek sebelum mahasiswa mengirim aplikasi." />
        <div class="grid gap-4">
            <x-comic-panel soft class="p-5">
                <h3 class="text-lg font-black">Apakah bisa daftar lebih dari sekali?</h3>
                <p class="mt-2 text-sm leading-6 text-neutral-700">Satu mahasiswa hanya bisa mengirim satu aplikasi pada periode rekrutmen yang sama.</p>
            </x-comic-panel>
            <x-comic-panel soft class="p-5">
                <h3 class="text-lg font-black">Kapan aplikasi bisa dikirim?</h3>
                <p class="mt-2 text-sm leading-6 text-neutral-700">Aplikasi hanya bisa dikirim saat status periode rekrutmen terbuka dan tanggal pendaftaran masih aktif.</p>
            </x-comic-panel>
            <x-comic-panel soft class="p-5">
                    <h3 class="text-lg font-black">Apakah CV wajib diupload?</h3>
                    <p class="mt-2 text-sm leading-6 text-neutral-700">Ya. CV wajib dilampirkan saat mengirim aplikasi agar berkas pendaftaran lengkap sejak awal.</p>
                </x-comic-panel>
            </div>
    </section>

    <section class="mt-24">
        <x-comic-panel class="relative overflow-hidden p-8 md:p-10">
            <div class="speed-lines absolute inset-0 opacity-20"></div>
            <div class="relative grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <p class="burst-label mb-5">Ready?</p>
                    <h2 class="text-4xl font-black leading-tight md:text-5xl">Siapkan akun dan CV, lalu pilih rekrutmen.</h2>
                    <p class="mt-3 max-w-2xl text-neutral-700">Cek kuota, tanggal, organisasi, dan divisi sebelum mengirim motivasi terbaikmu.</p>
                </div>
                <x-ink-button :href="route('recruitments.index')">Buka Rekrutmen</x-ink-button>
            </div>
        </x-comic-panel>
    </section>
@endsection
