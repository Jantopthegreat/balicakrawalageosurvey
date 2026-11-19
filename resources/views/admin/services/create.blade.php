@extends('admin.layout')

@section('title', 'Layanan Baru')
@section('main-class', 'admin-dashboard')

@section('content')
<div class="admin-contact-page">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 19h16"/><path d="M6 16V5h12v11"/><path d="M9 8h6M9 11h6M9 14h3"/>
            </svg>
            <h1>Tambah Layanan</h1>
        </div>
        <p>Tambahkan layanan baru untuk ditampilkan pada website.</p>
    </header>

    <section class="admin-contact-form-card">
        <div class="admin-contact-form-header">
            <div><h2>Informasi Layanan</h2><p>Lengkapi informasi layanan di bawah ini.</p></div>
        </div>
        <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.services._form')
        </form>
    </section>
</div>
@endsection
