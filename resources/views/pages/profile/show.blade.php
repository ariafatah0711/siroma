@extends('layouts.public', ['title' => 'Profil - SIROMA'])

@section('content')
    <section class="grid gap-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-start">
        <div class="grid gap-5">
            <x-comic-panel class="relative overflow-hidden p-6">
                <div class="speed-lines absolute inset-0 opacity-20"></div>
                <div class="relative">
                    <p class="burst-label mb-5">Student Profile</p>
                    <h1 class="text-4xl font-black leading-tight">{{ $user->full_name }}</h1>
                    <p class="mt-2 font-mono text-sm font-black">{{ $user->student_number }}</p>
                    <p class="mt-3 text-sm font-semibold text-neutral-700">{{ $user->email }}</p>
                </div>
            </x-comic-panel>

            <x-comic-panel soft class="p-5">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">Status Akun</p>
                <p class="mt-2 text-2xl font-black">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</p>
                <p class="mt-2 text-sm leading-6 text-neutral-700">Role dan akses khusus, termasuk izin membuat rekrutmen, diberikan oleh admin platform.</p>
            </x-comic-panel>

            <x-comic-panel soft class="p-5">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">Pendaftaran</p>
                <p class="mt-2 text-4xl font-black">{{ $applications->count() }}</p>
                <p class="mt-2 text-sm leading-6 text-neutral-700">Total aplikasi rekrutmen yang pernah kamu kirim.</p>
            </x-comic-panel>
        </div>

        <div>
            <x-section-heading eyebrow="Edit" title="Perbarui profil" description="Data ini dipakai saat kamu mendaftar rekrutmen organisasi mahasiswa." />

            @if ($errors->any())
                <div class="mt-6 border-3 border-red-800 bg-red-50 p-4 text-sm text-red-900 shadow-[5px_5px_0_#7f1d1d]">
                    <b>Periksa lagi input kamu:</b>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}" class="comic-panel mt-8 grid gap-5 p-5 md:grid-cols-2 md:p-7">
                @csrf
                @method('PUT')

                <label class="grid gap-2 font-bold">
                    NIM
                    <input type="text" name="student_number" value="{{ old('student_number', $user->student_number) }}" class="border-2 border-neutral-950 px-3 py-3" required>
                </label>

                <label class="grid gap-2 font-bold">
                    Nama Lengkap
                    <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}" class="border-2 border-neutral-950 px-3 py-3" required>
                </label>

                <label class="grid gap-2 font-bold md:col-span-2">
                    Email
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="border-2 border-neutral-950 px-3 py-3" required>
                </label>

                <label class="grid gap-2 font-bold">
                    No. HP
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="border-2 border-neutral-950 px-3 py-3">
                </label>

                <label class="grid gap-2 font-bold">
                    Tahun Masuk
                    <input type="number" name="entry_year" value="{{ old('entry_year', $user->entry_year) }}" class="border-2 border-neutral-950 px-3 py-3">
                </label>

                <label class="grid gap-2 font-bold">
                    Fakultas
                    <input type="text" name="faculty" value="{{ old('faculty', $user->faculty) }}" class="border-2 border-neutral-950 px-3 py-3">
                </label>

                <label class="grid gap-2 font-bold">
                    Program Studi
                    <input type="text" name="study_program" value="{{ old('study_program', $user->study_program) }}" class="border-2 border-neutral-950 px-3 py-3">
                </label>

                <div class="comic-panel-soft grid gap-5 p-4 md:col-span-2 md:grid-cols-3">
                    <p class="text-sm font-black uppercase tracking-[0.16em] text-neutral-600 md:col-span-3">Ganti Password Opsional</p>
                    <label class="grid gap-2 font-bold">
                        Password Sekarang
                        <input type="password" name="current_password" class="border-2 border-neutral-950 px-3 py-3">
                    </label>
                    <label class="grid gap-2 font-bold">
                        Password Baru
                        <input type="password" name="password" class="border-2 border-neutral-950 px-3 py-3">
                    </label>
                    <label class="grid gap-2 font-bold">
                        Konfirmasi Password
                        <input type="password" name="password_confirmation" class="border-2 border-neutral-950 px-3 py-3">
                    </label>
                </div>

                <div class="md:col-span-2">
                    <x-ink-button type="submit">Simpan Profil</x-ink-button>
                </div>
            </form>
        </div>
    </section>

    <section class="mt-14">
        <x-section-heading eyebrow="History" title="Pendaftaran kamu" description="Daftar aplikasi rekrutmen yang pernah kamu kirim melalui akun ini." />
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            @forelse ($applications as $application)
                <a href="{{ route('applications.show', $application) }}" class="comic-panel-soft block p-5 hover:bg-neutral-100">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <p class="font-mono text-sm font-black">{{ $application->application_code }}</p>
                        <x-status-badge :status="$application->application_status" />
                    </div>
                    <h3 class="mt-4 text-xl font-black">{{ $application->recruitmentPeriod->recruitment_title }}</h3>
                    <p class="mt-2 text-sm font-semibold text-neutral-700">{{ $application->recruitmentPeriod->organization->organization_name }}</p>
                    <p class="mt-3 text-xs font-bold text-neutral-600">Dikirim {{ $application->submitted_at->translatedFormat('d M Y H:i') }}</p>
                </a>
            @empty
                <p class="comic-panel-soft p-5 text-sm font-semibold text-neutral-700">Kamu belum mengirim pendaftaran rekrutmen.</p>
            @endforelse
        </div>
    </section>
@endsection
