
@extends('admin.layout')

@section('title', 'Tambah Mitra')
@section('main-class', 'admin-dashboard')

@section('content')

<div class="admin-mitra-page">

    <header class="admin-dashboard-header">

        <div class="admin-dashboard-title">

            <svg viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">
                <circle cx="9" cy="8" r="3"/>
                <circle cx="17" cy="9" r="2"/>
                <path d="M3 20v-1a6 6 0 0 1 12 0v1"/>
                <path d="M15 15a4 4 0 0 1 6 3.5V20"/>
            </svg>

            <h1>Tambah Mitra</h1>

        </div>

        <p>
            Tambahkan informasi dan logo mitra untuk ditampilkan
            pada halaman beranda.
        </p>

    </header>


    <section class="admin-mitra-form-card">

        <div class="admin-mitra-form-header">

            <div>
                <h2>Informasi Mitra</h2>
                <p>Lengkapi identitas mitra dan unggah logo perusahaan.</p>
            </div>



        </div>


        <form
            action="{{ route('admin.mitra.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            @include('admin.mitra._form')

        </form>

    </section>

</div>

@endsection
