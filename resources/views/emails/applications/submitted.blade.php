<x-mail::message>
# Pendaftaran Terkirim

Hai **{{ $application->user->full_name }}**,

Pendaftaran kamu untuk **{{ $application->recruitmentPeriod->recruitment_title }}** sudah kami terima.

<x-mail::panel>
**Kode Pendaftaran:** {{ $application->application_code }}
**Status:** {{ ucfirst(str_replace('_', ' ', $application->application_status)) }}
</x-mail::panel>

## Tahap Selanjutnya

1. **Review Berkas** — Tim kami akan memeriksa CV dan motivasi kamu.
2. **Undangan Wawancara** — Jika lolos seleksi berkas, kamu akan diundang wawancara.
3. **Pengumuman** — Hasil akhir akan diinfokan melalui email ini.

<x-mail::button :url="route('applications.show', $application)" color="primary">
Lihat Status Pendaftaran
</x-mail::button>

Jika ada pertanyaan, hubungi **{{ $application->recruitmentPeriod->organization->organization_name }}** melalui email {{ $application->recruitmentPeriod->organization->contact_email ?? '-' }} atau telepon {{ $application->recruitmentPeriod->organization->contact_phone ?? '-' }}.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
