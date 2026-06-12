@extends('layouts.public', ['title' => 'Organisasi - SIROMA'])

@section('content')
    <x-section-heading eyebrow="Directory" title="Organisasi" description="Daftar organisasi mahasiswa yang membuka dan mengelola periode rekrutmen di SIROMA." />
    <div class="mt-8 grid gap-4 md:grid-cols-2">
        @foreach ($organizations as $organization)
            <x-organization-card :organization="$organization">
            </x-organization-card>
        @endforeach
    </div>
@endsection
