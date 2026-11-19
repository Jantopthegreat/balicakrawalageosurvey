
@extends('admin.layout')

@section('title', 'Tambah Kontak')

@section('content')

<div class="admin-dashboard admin-contact-page">

    <header class="admin-dashboard-header">

        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <path d="m3 7 9 6 9-6"/>
            </svg>

            <h1>Tambah Kontak</h1>
        </div>

        <p>
            Tambahkan informasi kontak perusahaan untuk ditampilkan pada website.
        </p>

    </header>

    <section class="admin-contact-form-card">

        <div class="admin-contact-form-header">
            <div>
                <h2>Informasi Kontak</h2>
                <p>Lengkapi informasi kontak perusahaan di bawah ini.</p>
            </div>

        </div>

        <form
            action="{{ route('admin.contact.store') }}"
            method="POST"
        >
            @csrf

            @include('admin.contact._form')

        </form>

    </section>

</div>

@endsection
