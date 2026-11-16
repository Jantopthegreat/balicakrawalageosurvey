@extends('admin.layout')

@section('title', 'Kelola Katalog')
@section('main-class', 'admin-dashboard')

@section('content')
<div class="admin-contact-page">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="m4 8 2-4h12l2 4"/>
                <path d="M5 8h14v11H5z"/>
                <path d="M8 12h8"/>
            </svg>
            <h1>Products</h1>
        </div>
        <p>Kelola produk yang ditampilkan pada halaman katalog.</p>
    </header>

    @if (session('status'))
        <div class="admin-contact-success" role="status"><span>✓</span>{{ session('status') }}</div>
    @endif

    <section class="dashboard-section">
        <div class="admin-contact-section-header">
            <div>
                <h2 class="dashboard-section-title">Data Products</h2>
                <p class="admin-contact-subtitle">Daftar produk yang digunakan oleh website.</p>
            </div>
            <a class="admin-contact-add" href="{{ route('admin.products.create') }}"><span>+</span>Tambah Produk</a>
        </div>

        <div class="admin-contact-table-wrap">
            <div class="admin-contact-table-header">
                <h3>Daftar Products</h3>
                <span>{{ $products->total() }} data</span>
            </div>
            <div class="admin-contact-table-scroll">
                <table class="admin-contact-table">
                    <thead><tr><th>Nama</th><th>Kategori</th><th>Jenis</th><th>Ketersediaan</th><th class="text-center">Aksi</th></tr></thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="contact-name"><strong>{{ $product->name }}</strong>@if ($loop->first && $products->currentPage() === 1)<span class="contact-latest-badge">Terbaru</span>@endif</td>
                                <td data-label="Kategori">{{ $product->category }}</td>
                                <td data-label="Jenis">{{ $product->type === 'rent' ? 'Sewa' : 'Jual' }}</td>
                                <td data-label="Ketersediaan">{{ $product->availability }}</td>
                                <td class="contact-actions-cell">
                                    <div class="admin-contact-actions">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="admin-contact-edit">Edit</a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-contact-delete">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5"><div class="admin-contact-empty"><span class="admin-contact-empty-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path d="m4 8 2-4h12l2 4"/><path d="M5 8h14v11H5z"/></svg></span><strong>Belum ada data produk</strong><p>Tambahkan produk agar website dapat menampilkan katalog.</p><a href="{{ route('admin.products.create') }}" class="admin-contact-add">+ Tambah Produk</a></div></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($products->hasPages())
                <div class="admin-contact-pagination">{{ $products->links() }}</div>
            @endif
        </div>
    </section>
</div>
@endsection
