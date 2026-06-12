@extends('layouts.public', ['title' => 'Register - SIROMA'])

@section('content')
    <div class="mx-auto max-w-3xl">
        <x-section-heading eyebrow="Register" title="Buat akun mahasiswa" description="Akun ini dipakai untuk mengirim pendaftaran rekrutmen dan melihat status aplikasi." />

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

        <form method="POST" action="{{ route('register.store') }}" class="comic-panel mt-8 grid gap-5 p-5 md:grid-cols-2 md:p-7">
            @csrf
            <label class="grid gap-2 font-bold">
                NIM
                <input type="text" name="student_number" value="{{ old('student_number') }}" class="border-2 border-neutral-950 px-3 py-2" required>
            </label>

            <label class="grid gap-2 font-bold">
                Nama Lengkap
                <input type="text" name="full_name" value="{{ old('full_name') }}" class="border-2 border-neutral-950 px-3 py-2" required>
            </label>

            <label class="grid gap-2 font-bold md:col-span-2">
                Email
                <input type="email" name="email" value="{{ old('email') }}" class="border-2 border-neutral-950 px-3 py-2" required>
            </label>

            <label class="grid gap-2 font-bold">
                Password
                <input type="password" name="password" class="border-2 border-neutral-950 px-3 py-2" required>
            </label>

            <label class="grid gap-2 font-bold">
                Konfirmasi Password
                <input type="password" name="password_confirmation" class="border-2 border-neutral-950 px-3 py-2" required>
            </label>

            <label class="grid gap-2 font-bold">
                No. HP
                <input type="text" name="phone" value="{{ old('phone') }}" class="border-2 border-neutral-950 px-3 py-2">
            </label>

            <label class="grid gap-2 font-bold">
                Tahun Masuk
                <input type="number" name="entry_year" value="{{ old('entry_year') }}" class="border-2 border-neutral-950 px-3 py-2">
            </label>

            <label class="grid gap-2 font-bold">
                Fakultas
                <input type="text" name="faculty" value="{{ old('faculty') }}" class="border-2 border-neutral-950 px-3 py-2">
            </label>

            <label class="grid gap-2 font-bold">
                Program Studi
                <input type="text" name="study_program" value="{{ old('study_program') }}" class="border-2 border-neutral-950 px-3 py-2">
            </label>

            <div class="flex flex-wrap items-center gap-3 md:col-span-2">
                <x-ink-button type="submit">Register</x-ink-button>
                <x-ink-button :href="route('login')" variant="secondary">Sudah Punya Akun</x-ink-button>
            </div>
        </form>
    </div>
@endsection
