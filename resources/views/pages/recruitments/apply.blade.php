@extends('layouts.public', ['title' => 'Daftar '.$period->recruitment_title.' - SIROMA'])

@section('content')
    <x-section-heading eyebrow="Application Form" :title="'Daftar '.$period->recruitment_title" description="Pendaftaran akan dikirim memakai akun yang sedang login. Pilih divisi, tulis motivasi, dan upload CV agar berkas seleksi lengkap." />

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

    <form method="POST" action="{{ route('applications.store', $period) }}" enctype="multipart/form-data" class="comic-panel mt-8 grid max-w-4xl gap-6 p-5 md:p-7">
        @csrf
        <div class="grid gap-5 md:grid-cols-[0.85fr_1.15fr]">
            <div class="comic-panel-soft p-4">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">Mendaftar sebagai</p>
                <p class="mt-2 text-xl font-black">{{ auth()->user()->full_name }}</p>
                <p class="mt-1 text-sm font-semibold text-neutral-700">{{ auth()->user()->student_number }}</p>
                <p class="text-sm font-semibold text-neutral-700">{{ auth()->user()->email }}</p>
            </div>

            <div class="comic-panel-soft speed-lines p-4">
                <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-600">Checklist</p>
                <ul class="mt-3 grid gap-2 text-sm font-bold">
                    <li>Data akun login sudah dipakai otomatis.</li>
                    <li>Pilihan divisi pertama wajib diisi.</li>
                    <li>CV wajib diupload dalam format PDF/DOC/DOCX.</li>
                </ul>
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <label class="grid gap-2 font-bold">
                Pilihan Divisi Pertama
                <select name="first_division_id" class="border-2 border-neutral-950 bg-white px-3 py-3" required>
                    <option value="">Pilih divisi</option>
                    @foreach ($period->organization->divisions as $division)
                        <option value="{{ $division->id }}" @selected(old('first_division_id') == $division->id)>{{ $division->division_name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="grid gap-2 font-bold">
                Pilihan Divisi Kedua
                <select name="second_division_id" class="border-2 border-neutral-950 bg-white px-3 py-3">
                    <option value="">Tidak memilih</option>
                    @foreach ($period->organization->divisions as $division)
                        <option value="{{ $division->id }}" @selected(old('second_division_id') == $division->id)>{{ $division->division_name }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        <label class="grid gap-2 font-bold">
            Motivasi
            <textarea name="motivation" rows="6" class="border-2 border-neutral-950 px-3 py-3" placeholder="Ceritakan alasan kamu memilih organisasi/divisi ini minimal 20 karakter." required>{{ old('motivation') }}</textarea>
        </label>

        <label class="grid gap-3 font-bold">
            Upload CV
            <span class="comic-panel-soft grid gap-2 p-5">
                <span class="text-xl font-black">Berkas CV wajib</span>
                <span class="text-sm font-semibold text-neutral-700">Format PDF, DOC, atau DOCX. Maksimal 5 MB.</span>
                <input type="file" name="cv" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="mt-2 border-2 border-neutral-950 bg-white px-3 py-3" required>
            </span>
        </label>

        <x-ink-button type="submit">Kirim Pendaftaran</x-ink-button>
    </form>
@endsection
