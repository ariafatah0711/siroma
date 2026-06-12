@extends('layouts.public', ['title' => 'Daftar '.$period->recruitment_title.' - SIROMA'])

@section('content')
    <h1 class="text-4xl font-black">Daftar {{ $period->recruitment_title }}</h1>
    <p class="mt-2 text-neutral-700">Pilih akun dummy mahasiswa dan divisi yang diminati.</p>

    @if ($errors->any())
        <div class="mt-6 border-2 border-red-700 bg-red-50 p-4 text-sm text-red-900">
            <b>Periksa lagi input kamu:</b>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('applications.store', $period) }}" class="mt-8 grid max-w-3xl gap-5">
        @csrf
        <label class="grid gap-2 font-bold">
            Mahasiswa
            <select name="user_id" class="border-2 border-neutral-950 px-3 py-2" required>
                <option value="">Pilih mahasiswa</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->full_name }} - {{ $user->student_number }}</option>
                @endforeach
            </select>
        </label>

        <label class="grid gap-2 font-bold">
            Pilihan Divisi Pertama
            <select name="first_division_id" class="border-2 border-neutral-950 px-3 py-2" required>
                <option value="">Pilih divisi</option>
                @foreach ($period->organization->divisions as $division)
                    <option value="{{ $division->id }}" @selected(old('first_division_id') == $division->id)>{{ $division->division_name }}</option>
                @endforeach
            </select>
        </label>

        <label class="grid gap-2 font-bold">
            Pilihan Divisi Kedua
            <select name="second_division_id" class="border-2 border-neutral-950 px-3 py-2">
                <option value="">Tidak memilih</option>
                @foreach ($period->organization->divisions as $division)
                    <option value="{{ $division->id }}" @selected(old('second_division_id') == $division->id)>{{ $division->division_name }}</option>
                @endforeach
            </select>
        </label>

        <label class="grid gap-2 font-bold">
            Motivasi
            <textarea name="motivation" rows="6" class="border-2 border-neutral-950 px-3 py-2" required>{{ old('motivation') }}</textarea>
        </label>

        <button class="border-2 border-neutral-950 bg-neutral-950 px-5 py-3 font-bold text-white">Kirim Pendaftaran</button>
    </form>
@endsection
