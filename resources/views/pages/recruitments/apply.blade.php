@extends('layouts.public', ['title' => 'Daftar '.$period->recruitment_title.' - SIROMA'])

@section('content')
    <x-section-heading eyebrow="Application Form" :title="'Daftar '.$period->recruitment_title" description="Isi form di bawah dengan lengkap. CV wajib, dokumen lain bersifat opsional dan bisa ditambah dari awal." class="text-center" />

    @if ($errors->any())
        <div class="mt-6 border-3 border-red-800 bg-red-50 p-4 text-sm text-red-900 shadow-[5px_5px_0_#7f1d1d]">
            <b class="font-black">Periksa lagi input kamu:</b>
            <ul class="mt-2 list-disc pl-5 font-semibold">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('applications.store', $period) }}" enctype="multipart/form-data" class="comic-panel mx-auto mt-8 grid max-w-4xl gap-6 p-6 md:p-8">
        @csrf

        {{-- Info Pendaftar --}}
        <div class="grid gap-6 md:grid-cols-2">
            <div class="comic-panel-soft p-5 flex flex-col justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-500">Mendaftar sebagai</p>
                    <p class="mt-2 text-2xl font-black">{{ auth()->user()->full_name }}</p>
                    <p class="mt-1 font-mono text-sm font-bold text-neutral-600">{{ auth()->user()->student_number }}</p>
                </div>
                <div class="mt-4 pt-4 border-t-2 border-dashed border-neutral-300">
                    <p class="text-xs font-semibold text-neutral-600">Email Utama</p>
                    <p class="text-sm font-bold text-neutral-800">{{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="comic-panel-soft speed-lines p-5 flex flex-col justify-between">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-neutral-500">Petunjuk Pengisian</p>
                    <ul class="mt-3 space-y-2 text-sm font-bold text-neutral-800">
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 font-black">✓</span>
                            <span>Data akun pendaftar terisi otomatis.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 font-black">✓</span>
                            <span>Pilihan Divisi Pertama bersifat wajib.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-600 font-black">✓</span>
                            <span>CV wajib berformat PDF/DOC/DOCX.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-neutral-500 font-black">○</span>
                            <span class="text-neutral-600">Portfolio & Sertifikat opsional.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Pilihan Divisi --}}
        <div class="grid gap-6 md:grid-cols-2">
            <label class="grid gap-2 font-bold text-sm">
                <span>Pilihan Divisi Pertama <span class="text-red-600">*</span></span>
                <select name="first_division_id" class="border-2 border-neutral-950 bg-white px-3 py-3 font-semibold focus:outline-none focus:ring-2 focus:ring-neutral-950 transition" required>
                    <option value="">Pilih divisi utama</option>
                    @foreach ($period->organization->divisions->where('is_active', true) as $division)
                        <option value="{{ $division->id }}" @selected(old('first_division_id') == $division->id)>{{ $division->division_name }}</option>
                    @endforeach
                </select>
            </label>

            <label class="grid gap-2 font-bold text-sm">
                <span>Pilihan Divisi Kedua <span class="text-xs font-normal text-neutral-500">(opsional)</span></span>
                <select name="second_division_id" class="border-2 border-neutral-950 bg-white px-3 py-3 font-semibold focus:outline-none focus:ring-2 focus:ring-neutral-950 transition">
                    <option value="">Tidak memilih divisi kedua</option>
                    @foreach ($period->organization->divisions->where('is_active', true) as $division)
                        <option value="{{ $division->id }}" @selected(old('second_division_id') == $division->id)>{{ $division->division_name }}</option>
                    @endforeach
                </select>
            </label>
        </div>

        {{-- Motivasi --}}
        <label class="grid gap-2 font-bold text-sm">
            <span>Motivasi Keikutsertaan <span class="text-red-600">*</span></span>
            <textarea name="motivation" rows="5" class="border-2 border-neutral-950 px-3 py-3 font-semibold placeholder-neutral-400 focus:outline-none focus:ring-2 focus:ring-neutral-950 transition" placeholder="Ceritakan motivasi dan kontribusi yang ingin kamu berikan minimal 20 karakter." required>{{ old('motivation') }}</textarea>
        </label>

        {{-- Upload Berkas --}}
        <div class="grid gap-4 mt-2">
            <h3 class="font-black uppercase tracking-wider text-sm border-b-2 border-neutral-950 pb-2">Berkas Pendaftaran</h3>

            <div class="grid gap-4 sm:grid-cols-2">
                {{-- Upload CV (wajib) --}}
                <label class="grid gap-2 font-bold text-sm">
                    <span>CV / Resume <span class="text-red-600">*</span></span>
                    <span class="comic-panel-soft flex flex-col justify-between p-4 h-full min-h-[140px] hover:bg-neutral-50 transition cursor-pointer">
                        <span>
                            <span class="block text-base font-black text-neutral-950">Upload Curriculum Vitae</span>
                            <span class="block text-xs font-semibold text-neutral-600 mt-1">PDF, DOC, DOCX. Maksimal 5 MB.</span>
                        </span>
                        <input type="file" name="cv" accept=".pdf,.doc,.docx" class="mt-3 w-full text-xs font-bold file:mr-3 file:py-1.5 file:px-3 file:border-2 file:border-neutral-950 file:bg-white file:text-xs file:font-black file:uppercase file:cursor-pointer hover:file:bg-neutral-100" required>
                    </span>
                </label>

                {{-- Portfolio (opsional) --}}
                <label class="grid gap-2 font-bold text-sm">
                    <span>Portfolio <span class="text-xs font-normal text-neutral-500">(opsional)</span></span>
                    <span class="comic-panel-soft flex flex-col justify-between p-4 h-full min-h-[140px] hover:bg-neutral-50 transition cursor-pointer">
                        <span>
                            <span class="block text-base font-black text-neutral-950">Upload Portofolio Karya</span>
                            <span class="block text-xs font-semibold text-neutral-600 mt-1">PDF, JPG, PNG. Maksimal 10 MB.</span>
                        </span>
                        <input type="file" name="portfolio" accept=".pdf,.jpg,.jpeg,.png" class="mt-3 w-full text-xs font-bold file:mr-3 file:py-1.5 file:px-3 file:border-2 file:border-neutral-950 file:bg-white file:text-xs file:font-black file:uppercase file:cursor-pointer hover:file:bg-neutral-100">
                    </span>
                </label>

                {{-- Sertifikat (opsional) --}}
                <label class="grid gap-2 font-bold text-sm">
                    <span>Sertifikat & Penghargaan <span class="text-xs font-normal text-neutral-500">(opsional)</span></span>
                    <span class="comic-panel-soft flex flex-col justify-between p-4 h-full min-h-[140px] hover:bg-neutral-50 transition cursor-pointer">
                        <span>
                            <span class="block text-base font-black text-neutral-950">Sertifikat Pendukung</span>
                            <span class="block text-xs font-semibold text-neutral-600 mt-1">PDF, JPG, PNG. Maksimal 10 MB.</span>
                        </span>
                        <input type="file" name="certificate" accept=".pdf,.jpg,.jpeg,.png" class="mt-3 w-full text-xs font-bold file:mr-3 file:py-1.5 file:px-3 file:border-2 file:border-neutral-950 file:bg-white file:text-xs file:font-black file:uppercase file:cursor-pointer hover:file:bg-neutral-100">
                    </span>
                </label>

                {{-- Dokumen lain (opsional) --}}
                <label class="grid gap-2 font-bold text-sm">
                    <span>Dokumen Tambahan Lainnya <span class="text-xs font-normal text-neutral-500">(opsional)</span></span>
                    <span class="comic-panel-soft flex flex-col justify-between p-4 h-full min-h-[140px] hover:bg-neutral-50 transition cursor-pointer">
                        <span>
                            <span class="block text-base font-black text-neutral-950">Berkas Pendukung Lain</span>
                            <span class="block text-xs font-semibold text-neutral-600 mt-1">PDF, JPG, PNG, DOC, DOCX. Maks 10 MB.</span>
                        </span>
                        <input type="file" name="other_document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="mt-3 w-full text-xs font-bold file:mr-3 file:py-1.5 file:px-3 file:border-2 file:border-neutral-950 file:bg-white file:text-xs file:font-black file:uppercase file:cursor-pointer hover:file:bg-neutral-100">
                    </span>
                </label>
            </div>
        </div>

        <div class="text-center mt-6">
            <x-ink-button type="submit" class="px-8 py-4 text-base">Kirim Pendaftaran</x-ink-button>
        </div>
    </form>
@endsection
