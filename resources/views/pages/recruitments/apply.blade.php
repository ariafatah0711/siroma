@extends('layouts.public', ['title' => 'Daftar '.$period->recruitment_title.' - SIROMA'])

@section('content')
    <x-section-heading eyebrow="Application Form" :title="'Daftar '.$period->recruitment_title" description="Pilih akun mahasiswa dummy, tentukan divisi prioritas, lalu tulis motivasi dengan jelas." />

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

    <form method="POST" action="{{ route('applications.store', $period) }}" class="comic-panel mt-8 grid max-w-3xl gap-5 p-5 md:p-7">
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

        <x-ink-button type="submit">Kirim Pendaftaran</x-ink-button>
    </form>
@endsection
