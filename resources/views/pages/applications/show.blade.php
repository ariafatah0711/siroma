@extends('layouts.public', ['title' => 'Status Pendaftaran '.$application->application_code.' - SIROMA'])

@section('content')
    @if (session('status'))
        <div class="mb-8 border-3 border-green-800 bg-green-50 p-4 text-sm font-bold text-green-900 shadow-[5px_5px_0_#166534]">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-8 border-3 border-red-800 bg-red-50 p-4 text-sm font-bold text-red-900 shadow-[5px_5px_0_#991b1b]">
            {{ session('error') }}
        </div>
    @endif

    <x-comic-panel class="relative overflow-hidden p-6 md:p-8">
        <div class="speed-lines absolute inset-0 opacity-20"></div>
        <div class="relative">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="burst-label">{{ $application->application_code }}</p>
                <x-status-badge :status="$application->application_status" />
            </div>
            <h1 class="mt-4 text-4xl font-black leading-tight md:text-5xl">{{ $application->recruitmentPeriod->recruitment_title }}</h1>
            <p class="mt-3 text-lg font-semibold text-neutral-700">{{ $application->user->full_name }} — {{ $application->recruitmentPeriod->organization->organization_name }}</p>
        </div>
    </x-comic-panel>

    <div class="mt-8 grid gap-4 sm:grid-cols-3">
        <x-stat-card label="Status" :value="str($application->application_status)->replace('_', ' ')->title()" />
        <x-stat-card label="Nilai Akhir" :value="$application->final_score ?? '-'" />
        <x-stat-card label="Dikirim" :value="$application->submitted_at->translatedFormat('d M Y H:i')" />
    </div>

    @if ($application->application_status === 'submitted' || $application->application_status === 'under_review')
        <section class="mt-10">
            <x-comic-panel class="relative overflow-hidden p-5 md:p-7">
                <div class="screentone absolute inset-y-0 right-0 w-1/3 opacity-30"></div>
                <div class="relative">
                    <x-section-heading eyebrow="Alur Seleksi" title="Tahap setelah daftar" description="Pendaftaran tidak langsung diterima. Ada beberapa tahap yang harus dilewati." class="text-center" />
                    <div class="mt-8 grid gap-0 sm:grid-cols-3">
                        <div class="comic-panel-soft border-b-4 border-neutral-950 p-5 text-center sm:border-b-0 sm:border-r-4">
                            <p class="inline-block border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black">01</p>
                            <h3 class="mt-3 text-lg font-black">Review Berkas</h3>
                            <p class="mt-2 text-sm leading-6 text-neutral-700">Tim meninjau CV dan motivasi. Jika lengkap, lanjut ke wawancara.</p>
                        </div>
                        <div class="comic-panel-soft border-b-4 border-neutral-950 p-5 text-center sm:border-b-0 sm:border-r-4">
                            <p class="inline-block border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black">02</p>
                            <h3 class="mt-3 text-lg font-black">Wawancara</h3>
                            <p class="mt-2 text-sm leading-6 text-neutral-700">Kamu akan diundang oleh tim rekrutmen organisasi terkait.</p>
                        </div>
                        <div class="comic-panel-soft p-5 text-center">
                            <p class="inline-block border-2 border-neutral-950 bg-white px-3 py-1 text-xs font-black">03</p>
                            <h3 class="mt-3 text-lg font-black">Pengumuman</h3>
                            <p class="mt-2 text-sm leading-6 text-neutral-700">Hasil akhir akan diinfokan melalui email yang terdaftar.</p>
                        </div>
                    </div>
                </div>
            </x-comic-panel>
        </section>
    @endif

    <div class="mt-10 grid gap-10 md:grid-cols-2">
        <section>
            <x-comic-panel class="p-6 h-full flex flex-col justify-between">
                <div>
                    <p class="burst-label mb-5">Pilihan Divisi</p>
                    <ol class="grid gap-4">
                        @foreach ($application->preferences as $preference)
                            <li class="comic-panel-soft flex items-center gap-4 p-4">
                                <span class="grid h-10 w-10 shrink-0 place-items-center border-2 border-neutral-950 bg-white text-lg font-black">{{ $preference->preference_order }}</span>
                                <span class="font-black text-neutral-900">{{ $preference->division->division_name }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
                <div class="mt-6 p-4 border-2 border-neutral-950 bg-neutral-50 font-semibold text-sm leading-relaxed">
                    <p class="font-black text-xs uppercase tracking-wider text-neutral-500 mb-1">Motivasi Kamu:</p>
                    <p class="text-neutral-800">"{{ $application->motivation }}"</p>
                </div>
            </x-comic-panel>
        </section>

        <section>
            <x-comic-panel class="p-6">
                <p class="burst-label mb-5">Dokumen Berkas</p>
                <div class="grid gap-3 mb-5">
                    @forelse ($application->documents as $document)
                        <div class="comic-panel-soft flex flex-wrap items-center justify-between gap-3 p-4">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="border-2 border-neutral-950 bg-white px-2 py-1 text-xs font-black uppercase tracking-wider shrink-0 shadow-[2px_2px_0_#141414]">
                                    {{ $document->document_type }}
                                </div>
                                <span class="text-sm font-bold text-neutral-800 truncate" title="{{ $document->original_file_name }}">
                                    {{ $document->original_file_name }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="border-2 border-neutral-950 bg-white hover:bg-neutral-100 px-3 py-1.5 text-xs font-black uppercase tracking-wide transition shadow-[2px_2px_0_#141414] active:translate-y-0.5 active:shadow-[1px_1px_0_#141414]">
                                    Unduh
                                </a>
                                @if ($document->document_type !== 'cv')
                                    <form method="POST" action="{{ route('applications.deleteDocument', [$application, $document]) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" class="border-2 border-red-600 bg-red-50 text-red-700 hover:bg-red-100 px-3 py-1.5 text-xs font-black uppercase tracking-wide transition shadow-[2px_2px_0_#dc2626] active:translate-y-0.5 active:shadow-[1px_1px_0_#dc2626]">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-neutral-700">Belum ada dokumen tambahan yang diunggah.</p>
                    @endforelse
                </div>

                @if ($application->application_status === 'submitted' || $application->application_status === 'under_review')
                    <form method="POST" action="{{ route('applications.uploadDocument', $application) }}" enctype="multipart/form-data" class="border-t-2 border-neutral-950 pt-5 mt-5">
                        @csrf
                        <p class="font-black text-sm uppercase tracking-wide mb-3 text-neutral-900">Unggah Dokumen Tambahan</p>
                        <div class="grid gap-4">
                            <label class="grid gap-2 font-bold text-xs">
                                <span>TIPE DOKUMEN</span>
                                <select name="document_type" required class="border-2 border-neutral-950 bg-white px-3 py-2.5 font-bold text-sm focus:outline-none focus:ring-2 focus:ring-neutral-950 transition">
                                    <option value="">Pilih tipe dokumen</option>
                                    <option value="portfolio">Portfolio</option>
                                    <option value="certificate">Sertifikat</option>
                                    <option value="transcript">Transkrip Nilai</option>
                                    <option value="other">Lainnya</option>
                                </select>
                                @error('document_type')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="grid gap-2 font-bold text-xs">
                                <span>PILIH BERKAS (PDF, JPG, PNG, DOCX - MAX 10MB)</span>
                                <input type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required class="border-2 border-neutral-950 bg-white px-3 py-2 font-semibold text-sm file:mr-2 file:py-1 file:px-2 file:border-2 file:border-neutral-950 file:bg-white file:text-xs file:font-black file:uppercase file:cursor-pointer hover:file:bg-neutral-50">
                                @error('document')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <button type="submit" class="border-2 border-neutral-950 bg-white px-4 py-2.5 text-sm font-black uppercase hover:bg-neutral-100 transition shadow-[3px_3px_0_#141414] active:translate-y-0.5 active:shadow-[1px_1px_0_#141414] cursor-pointer">
                                Upload Dokumen
                            </button>
                        </div>
                    </form>
                @endif
            </x-comic-panel>
        </section>
    </div>

    {{-- Riwayat Status --}}
    <section class="mt-10">
        <x-comic-panel class="p-6">
            <x-section-heading eyebrow="Timeline" title="Riwayat Status" class="text-center" />
            
            <div class="mt-8 relative border-l-4 border-neutral-950 ml-4 md:ml-8 pl-6 space-y-6">
                @foreach ($application->statusHistory as $history)
                    <div class="relative">
                        <!-- Bulatan timeline diposisikan absolut agar presisi di tengah garis kiri -->
                        <div class="absolute -left-[32px] top-1.5 h-4 w-4 rounded-full border-2 border-neutral-950 bg-white z-10 shadow-[2px_2px_0_#141414]"></div>
                        
                        <div class="comic-panel-soft p-4 inline-block min-w-[280px] md:min-w-[400px]">
                            <div class="flex items-center justify-between gap-3">
                                <p class="font-black text-base uppercase tracking-wider text-neutral-900">
                                    {{ ucfirst(str_replace('_', ' ', $history->new_status)) }}
                                </p>
                                <span class="font-mono text-xs font-bold text-neutral-500">
                                    {{ $history->changed_at->translatedFormat('d M Y H:i') }}
                                </span>
                            </div>
                            @if ($history->change_note)
                                <p class="mt-2 text-sm font-semibold text-neutral-700 leading-relaxed border-t border-neutral-200 pt-2">
                                    {{ $history->change_note }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </x-comic-panel>
    </section>

    <section class="mt-10">
        <x-comic-panel class="relative overflow-hidden p-6">
            <div class="speed-lines absolute inset-0 opacity-20"></div>
            <div class="relative text-center">
                <p class="burst-label mb-3">Kontak</p>
                <h2 class="text-2xl font-black">Butuh bantuan?</h2>
                <p class="mt-3 text-sm leading-6 text-neutral-700">
                    Semua informasi seleksi dikirim melalui email <strong>{{ $application->user->email }}</strong>.
                    Jika tidak menerima email, hubungi organisasi terkait.
                </p>
                <div class="mt-5 flex flex-wrap justify-center gap-6 text-sm font-bold">
                    @if ($application->recruitmentPeriod->organization->contact_email)
                        <span class="border-2 border-neutral-950 bg-white px-3 py-2 shadow-[3px_3px_0_#141414]">Email: {{ $application->recruitmentPeriod->organization->contact_email }}</span>
                    @endif
                    @if ($application->recruitmentPeriod->organization->contact_phone)
                        <span class="border-2 border-neutral-950 bg-white px-3 py-2 shadow-[3px_3px_0_#141414]">Telp: {{ $application->recruitmentPeriod->organization->contact_phone }}</span>
                    @endif
                </div>
            </div>
        </x-comic-panel>
    </section>
@endsection
