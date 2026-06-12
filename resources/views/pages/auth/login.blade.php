@extends('layouts.public', ['title' => 'Login - SIROMA'])

@section('content')
    <div class="mx-auto max-w-xl">
        <x-section-heading eyebrow="Login" title="Masuk ke SIROMA" description="Gunakan akun mahasiswa untuk daftar rekrutmen dan melihat status pendaftaran." />

        @if ($errors->any())
            <div class="mt-6 border-3 border-red-800 bg-red-50 p-4 text-sm text-red-900 shadow-[5px_5px_0_#7f1d1d]">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}" class="comic-panel mt-8 grid gap-5 p-5 md:p-7">
            @csrf
            <label class="grid gap-2 font-bold">
                Email
                <input type="email" name="email" value="{{ old('email') }}" class="border-2 border-neutral-950 px-3 py-2" required autofocus>
            </label>

            <label class="grid gap-2 font-bold">
                Password
                <input type="password" name="password" class="border-2 border-neutral-950 px-3 py-2" required>
            </label>

            <div class="flex flex-wrap items-center gap-3">
                <x-ink-button type="submit">Login</x-ink-button>
                <x-ink-button :href="route('register')" variant="secondary">Buat Akun</x-ink-button>
            </div>
        </form>
    </div>
@endsection
