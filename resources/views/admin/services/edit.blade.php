@extends('admin.layout')

@section('title', 'Edit Layanan')
@section('main-class', 'admin-dashboard')

@section('content')
<div class="admin-contact-page">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 19h16"/><path d="M6 16V5h12v11"/><path d="M9 8h6M9 11h6M9 14h3"/>
            </svg>
            <h1>Edit Layanan</h1>
        </div>
        <p>Perbarui informasi layanan yang ditampilkan pada website.</p>
    </header>

    @if (session('status'))
        <div class="admin-contact-success" role="status"><span>✓</span>{{ session('status') }}</div>
    @endif

    <section class="admin-contact-form-card">
        <div class="admin-contact-form-header">
            <div><h2>Perbarui Informasi Layanan</h2><p>{{ $service->judul }}</p></div>
        </div>
        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.services._form', ['service' => $service])
        </form>
    </section>
</div>
@endsection
