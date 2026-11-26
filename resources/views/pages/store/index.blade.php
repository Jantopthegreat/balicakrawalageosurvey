
@extends('layouts.app')

@section('title', 'Katalog | ' . config('cakrawala.brand.name'))
@section('meta_description', 'Jelajahi katalog peralatan survei untuk disewa maupun dibeli.')

@section('content')

<main class="catalog-page">
    <div class="container">

        {{-- ================================
             CATALOG HEADER
        ================================= --}}
        <header class="catalog-header">
            <h1>Catalog</h1>

            <form
                action="{{ route('store.index') }}"
                method="GET"
                class="catalog-search-form"
            >
                <input
                    type="search"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Search"
                    aria-label="Cari produk"
                >

                <select name="category" aria-label="Filter kategori">
                    <option value="">All Categories</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category }}"
                            @selected(request('category') === $category)
                        >
                            {{ $category }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" aria-label="Cari produk">
                    <span aria-hidden="true">⌕</span>
                </button>
            </form>
        </header>


        {{-- ================================
             RENT PRODUCTS
        ================================= --}}
        <section class="catalog-group">

            <div class="catalog-group-heading">
                <h2>Equipment for Rent</h2>
                <p>
                    Survey equipment available for your project needs.
                </p>
            </div>

            @if ($rentProducts->count() > 0)

                <div
                    class="catalog-products-carousel"
                    data-catalog-products-carousel
                >

                    {{-- Previous Button --}}
                    <button
                        type="button"
                        class="catalog-products-arrow"
                        data-catalog-prev
                        aria-label="Produk sewa sebelumnya"
                    >
                        &#10094;
                    </button>

                    {{-- Product Track --}}
                    <div
                        class="catalog-products-track"
                        data-catalog-track
                    >
                        @foreach ($rentProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    {{-- Next Button --}}
                    <button
                        type="button"
                        class="catalog-products-arrow"
                        data-catalog-next
                        aria-label="Produk sewa berikutnya"
                    >
                        &#10095;
                    </button>

                </div>

            @else

                <div class="catalog-empty">
                    <p>Tidak ada produk sewa yang ditemukan.</p>
                </div>

            @endif

            {{-- Rent Pagination --}}
            @if ($rentProducts->hasPages())
                <div class="catalog-pagination">
                    {{ $rentProducts->appends(request()->except(['rent_page', 'sale_page']))->links() }}
                </div>
            @endif

        </section>


        {{-- ================================
             SALE PRODUCTS
        ================================= --}}
        <section class="catalog-group">

            <div class="catalog-group-heading">
                <h2>Equipment for Sale</h2>
                <p>
                    Survey and mapping equipment available for purchase.
                </p>
            </div>

            @if ($saleProducts->count() > 0)

                <div
                    class="catalog-products-carousel"
                    data-catalog-products-carousel
                >

                    {{-- Previous Button --}}
                    <button
                        type="button"
                        class="catalog-products-arrow"
                        data-catalog-prev
                        aria-label="Produk jual sebelumnya"
                    >
                        &#10094;
                    </button>

                    {{-- Product Track --}}
                    <div
                        class="catalog-products-track"
                        data-catalog-track
                    >
                        @foreach ($saleProducts as $product)
                            <x-product-card :product="$product" />
                        @endforeach
                    </div>

                    {{-- Next Button --}}
                    <button
                        type="button"
                        class="catalog-products-arrow"
                        data-catalog-next
                        aria-label="Produk jual berikutnya"
                    >
                        &#10095;
                    </button>

                </div>

            @else

                <div class="catalog-empty">
                    <p>Tidak ada produk jual yang ditemukan.</p>
                </div>

            @endif

            {{-- Sale Pagination --}}
            @if ($saleProducts->hasPages())
                <div class="catalog-pagination">
                    {{ $saleProducts->appends(request()->except(['rent_page', 'sale_page']))->links() }}
                </div>
            @endif

        </section>

    </div>
</main>

@endsection
