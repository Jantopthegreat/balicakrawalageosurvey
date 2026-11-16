
@extends('admin.layout')

@section('title', 'Kelola Mitra')
@section('main-class', 'admin-dashboard')

@section('content')

<div class="admin-mitra-page">

    {{-- PAGE HEADER --}}
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

            <h1>Kelola Mitra</h1>

        </div>

        <p>
            Kelola logo dan informasi mitra yang ditampilkan pada halaman beranda.
        </p>

    </header>


    {{-- SUCCESS MESSAGE --}}
    @if (session('status'))
        <div class="admin-mitra-success" role="status">
            <span>✓</span>
            {{ session('status') }}
        </div>
    @endif


    {{-- SECTION HEADER --}}
    <section class="dashboard-section">

        <div class="admin-mitra-section-header">

            <div>
                <h2 class="dashboard-section-title">Data Mitra</h2>

                <p class="admin-mitra-subtitle">
                    Daftar perusahaan dan organisasi yang menjadi mitra.
                </p>
            </div>

            <a
                href="{{ route('admin.mitra.create') }}"
                class="admin-mitra-add"
            >
                <span>+</span>
                Tambah Mitra
            </a>

        </div>


        {{-- SUMMARY CARD --}}
        <div class="admin-mitra-summary">

            <div class="admin-mitra-summary-indicator"></div>

            <div class="admin-mitra-summary-content">
                <span>Total Mitra</span>
                <strong>{{ $mitra->total() }}</strong>
            </div>

            <div class="admin-mitra-summary-note">
                Mitra terdaftar pada website
            </div>

        </div>


        {{-- PARTNER TABLE --}}
        <section class="admin-mitra-table-wrap">

            <div class="admin-mitra-table-header">
                <h3>Daftar Mitra</h3>
                <span>{{ $mitra->total() }} data</span>
            </div>

            <div class="admin-mitra-table-scroll">

                <table class="admin-mitra-table">

                    <thead>
                        <tr>
                            <th>Nama Mitra</th>
                            <th>Preview Logo</th>
                            <th>Status Logo</th>
                            <th>Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($mitra as $item)

                            <tr>

                                {{-- PARTNER NAME --}}
                                <td class="admin-mitra-name">
                                    <strong>{{ $item->nama }}</strong>
                                </td>


                                {{-- IMAGE PREVIEW --}}
                                <td data-label="Preview Logo">

                                    <div class="admin-mitra-image-preview">

                                        @if ($item->image)

                                         <img
    src="{{ asset('storage/' . $item->image) }}"
    alt="Logo {{ $item->nama }}"
    loading="lazy"
>

                                        @else

                                            <div class="admin-mitra-no-image">
                                                <svg viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.6">
                                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                                    <path d="m21 15-5-5L5 21"/>
                                                </svg>
                                            </div>

                                        @endif

                                    </div>

                                </td>


                                {{-- IMAGE STATUS --}}
                                <td data-label="Status Logo">

                                    @if ($item->image)
                                        <span class="admin-mitra-status has-image">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="admin-mitra-status no-image">
                                            Belum ada
                                        </span>
                                    @endif

                                </td>


                                {{-- CREATED DATE --}}
                                <td data-label="Dibuat">
                                    {{ $item->created_at?->format('d M Y') ?? '-' }}
                                </td>


                                {{-- ACTIONS --}}
                                <td class="admin-mitra-actions-cell">

                                    <div class="admin-mitra-actions">

                                        <a
                                            href="{{ route('admin.mitra.edit', $item) }}"
                                            class="admin-mitra-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.mitra.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus mitra {{ addslashes($item->nama) }}?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-mitra-delete"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">

                                    <div class="admin-mitra-empty">

                                        <div class="admin-mitra-empty-icon">
                                            <svg viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.6">
                                                <circle cx="9" cy="8" r="3"/>
                                                <circle cx="17" cy="9" r="2"/>
                                                <path d="M3 20v-1a6 6 0 0 1 12 0v1"/>
                                            </svg>
                                        </div>

                                        <strong>Belum ada mitra</strong>

                                        <p>
                                            Tambahkan mitra pertama agar logo
                                            dapat ditampilkan pada halaman beranda.
                                        </p>

                                        <a
                                            href="{{ route('admin.mitra.create') }}"
                                            class="admin-mitra-add"
                                        >
                                            + Tambah Mitra
                                        </a>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- PAGINATION --}}
            @if ($mitra->hasPages())
                <div class="admin-mitra-pagination">
                    {{ $mitra->links() }}
                </div>
            @endif

        </section>

    </section>

</div>

@endsection
