@extends('admin.layout')

@section('title', 'Edit Produk')
@section('main-class', 'admin-dashboard')

@section('content')
<div class="admin-contact-page">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m4 8 2-4h12l2 4"/><path d="M5 8h14v11H5z"/><path d="M8 12h8"/>
            </svg>
            <h1>Edit Produk</h1>
        </div>
        <p>Perbarui informasi produk yang ditampilkan pada katalog.</p>
    </header>

    @if (session('status'))
        <div class="admin-contact-success" role="status"><span>✓</span>{{ session('status') }}</div>
    @endif

    <section class="admin-contact-form-card">
        <div class="admin-contact-form-header">
            <div><h2>Perbarui Informasi Produk</h2><p>{{ $product->name }}</p></div>
        </div>
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['product' => $product])
        </form>
    </section>
</div>
@endsection
