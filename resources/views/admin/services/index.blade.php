@extends('admin.layout')

@section('title', 'Kelola Layanan')
@section('main-class', 'admin-dashboard')

@section('content')
<div class="admin-contact-page">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M4 19h16"/>
                <path d="M6 16V5h12v11"/>
                <path d="M9 8h6M9 11h6M9 14h3"/>
            </svg>
            <h1>Layanan</h1>
        </div>
        <p>Kelola layanan yang ditampilkan pada website.</p>
    </header>

    @if (session('status'))
        <div class="admin-contact-success" role="status"><span>✓</span>{{ session('status') }}</div>
    @endif

    <section class="dashboard-section">
        <div class="admin-contact-section-header">
            <div>
                <h2 class="dashboard-section-title">Data Layanan</h2>
                <p class="admin-contact-subtitle">Daftar layanan yang digunakan oleh website.</p>
            </div>
            <a class="admin-contact-add" href="{{ route('admin.services.create') }}"><span>+</span>Tambah Layanan</a>
        </div>

        <div class="admin-contact-table-wrap">
            <div class="admin-contact-table-header">
                <h3>Daftar Layanan</h3>
                <span>{{ $services->total() }} data</span>
            </div>
            <div class="admin-contact-table-scroll">
                <table class="admin-contact-table">
                    <thead><tr><th>Judul</th><th>Deskripsi</th><th>Dibuat</th><th class="text-center">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($services as $service)
                            <tr>
                                <td class="contact-name"><strong>{{ $service->judul }}</strong>@if ($loop->first && $services->currentPage() === 1)<span class="contact-latest-badge">Terbaru</span>@endif</td>
                                <td data-label="Deskripsi">{{ $service->deskripsi }}</td>
                                <td data-label="Dibuat">{{ $service->created_at->format('d M Y H:i') }}</td>
                                <td class="contact-actions-cell">
                                    <div class="admin-contact-actions">
                                        <a href="{{ route('admin.services.edit', $service) }}" class="admin-contact-edit">Edit</a>
                                        <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Hapus layanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-contact-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4"><div class="admin-contact-empty"><span class="admin-contact-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="M4 19h16"/><path d="M6 16V5h12v11"/></svg></span><strong>Belum ada data layanan</strong><p>Tambahkan layanan agar website dapat menampilkan informasi jasa perusahaan.</p><a href="{{ route('admin.services.create') }}" class="admin-contact-add">+ Tambah Layanan</a></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($services->hasPages())
                <div class="admin-contact-pagination">{{ $services->links() }}</div>
            @endif
        </div>
    </section>
</div>
@endsection
