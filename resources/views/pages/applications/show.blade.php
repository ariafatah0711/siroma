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
            <x-comic-panel class="p-5">
                <p class="burst-label mb-4">Pilihan Divisi</p>
                <ol class="grid gap-3">
                    @foreach ($application->preferences as $preference)
                        <li class="comic-panel-soft flex items-center gap-4 p-4">
                            <span class="grid h-10 w-10 shrink-0 place-items-center border-2 border-neutral-950 bg-white text-lg font-black">{{ $preference->preference_order }}</span>
                            <span class="font-bold">{{ $preference->division->division_name }}</span>
                        </li>
                    @endforeach
                </ol>
            </x-comic-panel>
        </section>

        <section>
            <x-comic-panel class="p-5">
                <p class="burst-label mb-4">Dokumen</p>
                <div class="grid gap-3 mb-5">
                    @forelse ($application->documents as $document)
                        <div class="comic-panel-soft flex items-center justify-between gap-3 p-4 group">
                            <a href="{{ asset('storage/'.$document->file_path) }}" target="_blank" class="flex-1 flex items-center justify-between gap-3 hover:bg-neutral-100 cursor-pointer">
                                <span>
                                    <span class="font-black uppercase">{{ $document->document_type }}</span>
                                    <span class="ml-2 text-sm text-neutral-700">{{ $document->original_file_name }}</span>
                                </span>
                                <span class="shrink-0 border-2 border-neutral-950 bg-white px-2 py-1 text-xs font-black uppercase">Unduh</span>
                            </a>
                            @if ($document->document_type !== 'cv')
                                <form method="POST" action="{{ route('applications.deleteDocument', [$application, $document]) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus dokumen ini?')" class="px-2 py-1 text-xs font-black uppercase border-2 border-red-500 bg-red-50 text-red-700 hover:bg-red-100 transition">Hapus</button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-sm font-semibold text-neutral-700">Belum ada dokumen tambahan yang diunggah.</p>
                    @endforelse
                </div>

                @if ($application->application_status === 'submitted' || $application->application_status === 'under_review')
                    <form method="POST" action="{{ route('applications.uploadDocument', $application) }}" enctype="multipart/form-data" class="border-t-2 border-neutral-950 pt-4 mt-4">
                        @csrf
                        <p class="font-bold text-sm mb-3">Unggah Dokumen Tambahan</p>
                        <div class="grid gap-3">
                            <label class="grid gap-2 font-bold text-sm">
                                Tipe Dokumen
                                <select name="document_type" required class="border-2 border-neutral-950 bg-white px-3 py-2 text-sm">
                                    <option value="">Pilih tipe dokumen</option>
                                    <option value="cv">CV</option>
                                    <option value="portfolio">Portfolio</option>
                                    <option value="certificate">Sertifikat</option>
                                    <option value="transcript">Transkrip Nilai</option>
                                    <option value="other">Lainnya</option>
                                </select>
                                @error('document_type')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="grid gap-2 font-bold text-sm">
                                File (PDF, DOC, DOCX, JPG, PNG - Max 10MB)
                                <input type="file" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required class="border-2 border-neutral-950 bg-white px-3 py-2 text-sm">
                                @error('document')
                                    <span class="text-xs text-red-600">{{ $message }}</span>
                                @enderror
                            </label>

                            <button type="submit" class="border-2 border-neutral-950 bg-white px-3 py-2 text-sm font-bold uppercase hover:bg-neutral-100 transition">Upload Dokumen</button>
                        </div>
                    </form>
                @endif
            </x-comic-panel>
        </section>
    </div>

    <section class="mt-10">
        <x-comic-panel class="p-5">
            <x-section-heading eyebrow="Timeline" title="Riwayat Status" class="text-center" />
            <ol class="mt-6 grid gap-4">
                @foreach ($application->statusHistory as $history)
                    <li class="relative grid gap-3 border-l-4 border-neutral-950 pl-5">
                        <div class="absolute -left-[11px] top-1 h-4 w-4 rounded-full border-2 border-neutral-950 bg-white"></div>
                        <div class="grid gap-1">
                            <p class="font-black">{{ ucfirst(str_replace('_', ' ', $history->new_status)) }}</p>
                            @if ($history->change_note)
                                <p class="text-sm text-neutral-700">{{ $history->change_note }}</p>
                            @endif
                            <p class="text-xs font-bold text-neutral-600">{{ $history->changed_at->translatedFormat('d M Y H:i') }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
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
                        <span class="border-2 border-neutral-950 bg-white px-3 py-2">Email: {{ $application->recruitmentPeriod->organization->contact_email }}</span>
                    @endif
                    @if ($application->recruitmentPeriod->organization->contact_phone)
                        <span class="border-2 border-neutral-950 bg-white px-3 py-2">Telp: {{ $application->recruitmentPeriod->organization->contact_phone }}</span>
                    @endif
                </div>
            </div>
        </x-comic-panel>
    </section>
@endsection
