@extends('admin.layout')

@section('title', 'Produk Baru')
@section('main-class', 'admin-dashboard')

@section('content')
<div class="admin-contact-page">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m4 8 2-4h12l2 4"/><path d="M5 8h14v11H5z"/><path d="M8 12h8"/>
            </svg>
            <h1>Tambah Produk</h1>
        </div>
        <p>Tambahkan produk baru untuk ditampilkan pada katalog.</p>
    </header>

    <section class="admin-contact-form-card">
        <div class="admin-contact-form-header">
            <div><h2>Informasi Produk</h2><p>Lengkapi informasi produk di bawah ini.</p></div>
        </div>
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form')
        </form>
    </section>
</div>
@endsection
