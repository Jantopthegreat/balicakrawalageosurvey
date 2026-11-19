
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.partials.favicon')

    <title>Dashboard Admin | {{ config('cakrawala.brand.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body">

    <div class="admin-layout">

        {{-- SIDEBAR --}}
        @include('admin.partials.sidebar')


        {{-- MAIN CONTENT --}}
        <main class="admin-main admin-dashboard">

            {{-- PAGE HEADER --}}
            <header class="admin-dashboard-header">
                <div class="admin-dashboard-title">
                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>

                    <h1>Dashboard</h1>
                </div>

                <p>
                    Selamat datang, {{ auth()->user()->name }}
                </p>
            </header>


            {{-- TOTAL PRODUCTS --}}
            <section class="dashboard-section">

                <h2 class="dashboard-section-title">
                    Total Produk
                </h2>

                <article class="dashboard-total-card">

                    <div class="dashboard-card-indicator"></div>

                    <div class="dashboard-card-content">
                        <span>Total Produk</span>

                        <strong>{{ $totalProducts }}</strong>
                    </div>

                    <a href="{{ route('admin.products.index') }}"
                        class="dashboard-card-link">
                        Kelola Produk
                        <span>→</span>
                    </a>

                </article>

            </section>


            {{-- TOTAL BY TYPE --}}
            <section class="dashboard-section">

                <h2 class="dashboard-section-title">
                    Total Per Jenis
                </h2>

                <div class="dashboard-type-grid">

                    <article class="dashboard-type-card">

                        <div class="dashboard-card-indicator"></div>

                        <div>
                            <span>Produk Jual</span>
                            <strong>{{ $typeCounts['Sale'] }}</strong>
                        </div>

                    </article>


                    <article class="dashboard-type-card">

                        <div class="dashboard-card-indicator"></div>

                        <div>
                            <span>Produk Sewa</span>
                            <strong>{{ $typeCounts['Rent'] }}</strong>
                        </div>

                    </article>

                </div>

            </section>


            {{-- TOTAL BY CATEGORY --}}
            <section class="dashboard-section">

                <h2 class="dashboard-section-title">
                    Total Per Kategori
                </h2>

                <div class="dashboard-category-grid">

                    @forelse ($categoryCounts as $category)

                        <article class="dashboard-category-card">

                            <div class="dashboard-category-indicator"></div>

                            <div class="dashboard-category-content">

                                <span>{{ $category->category }}</span>

                                <strong>{{ $category->total }}</strong>

                            </div>

                            <a href="{{ route('admin.products.index') }}"
                                class="dashboard-category-link">
                                Lihat Produk →
                            </a>

                        </article>

                    @empty

                        <div class="dashboard-empty">
                            Belum ada kategori produk.
                        </div>

                    @endforelse

                </div>

            </section>




{{-- PRODUCT PREVIEW --}}
<section class="dashboard-section dashboard-preview">

    <div class="dashboard-preview-header">
        <div>
            <h2 class="dashboard-section-title">
                Preview
            </h2>
        </div>

        <a href="{{ route('admin.products.index') }}"
            class="dashboard-preview-link">
            Lihat Semua Produk →
        </a>
    </div>

    <div class="dashboard-product-showcase">

        <div class="dashboard-product-grid">

            @forelse ($previewProducts as $product)

                <article class="dashboard-product-card">

                    {{-- IMAGE --}}
                    <div class="dashboard-product-image">

                        @if ($product->image)
                            <img
                                src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                                alt="{{ $product->name }}"
                                loading="lazy"
                            >
                        @else
                            <div class="dashboard-product-no-image">
                                Tidak ada gambar
                            </div>
                        @endif

                        {{-- TYPE BADGE --}}
                        <span class="dashboard-product-badge">
                            {{ $product->type }}
                        </span>

                    </div>

                    {{-- PRODUCT DETAILS --}}
                    <div class="dashboard-product-info">

                        <h3>{{ $product->name }}</h3>

                        <span class="dashboard-product-category">
                            Jenis: {{ $product->category }}
                        </span>

                        <p class="dashboard-product-description">
                            {{ $product->description }}
                        </p>

                        <div class="dashboard-product-price">
                            Rp {{ $product->price_label }}
                        </div>

                    </div>

                </article>

            @empty

                <div class="dashboard-product-empty">
                    Belum ada produk yang tersedia.
                </div>

            @endforelse

        </div>

    </div>

</section>

        </main>

    </div>

</body>
</html>
