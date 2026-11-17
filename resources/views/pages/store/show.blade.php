
@extends('layouts.app')

@section('title', $product['name'] . ' | Katalog ' . config('cakrawala.brand.name'))
@section('meta_description', $product['description'])

@section('content')

@php
    $galleryImages = collect([$product['image'] ?? null])
        ->merge($product['images'] ?? [])
        ->filter()
        ->unique()
        ->values();

    $productType = $product['type'] ?? '';

    $typeLabel = match ($productType) {
        'rent' => 'Sewa',
        'sale' => 'Jual',
        default => 'Produk',
    };

    $whatsappNumber = preg_replace(
        '/\D+/',
        '',
        config('cakrawala.contact.whatsapp', '')
    );

    $whatsappMessage = 'Halo Cakrawala Geosurvey, saya tertarik dengan produk '
        . $product['name']
        . '. Mohon informasi lebih lanjut.';
@endphp

<section class="product-detail-section">

    <div
        class="container product-detail-layout"
        data-product-gallery
        data-interval="4500"
    >

        {{-- LEFT: PRODUCT GALLERY --}}
        <div class="product-detail-gallery-column">

            {{-- Main Image --}}
            <div class="product-detail-main-image">

                <img
                    src="{{ $galleryImages->first() ?? asset('images/products/product-placeholder.svg') }}"
                    alt="{{ $product['name'] }}"
                    data-product-main-image
                >

            </div>

            {{-- Thumbnail Gallery --}}
            @if ($galleryImages->isNotEmpty())

                <div class="product-detail-thumbnails">

                    @foreach ($galleryImages as $index => $image)

                        <button
                            type="button"
                            class="product-detail-thumbnail {{ $loop->first ? 'is-active' : '' }}"
                            data-product-thumbnail
                            data-index="{{ $index }}"
                            aria-label="Lihat foto {{ $index + 1 }}"
                            aria-pressed="{{ $loop->first ? 'true' : 'false' }}"
                        >

                            <img
                                src="{{ $image }}"
                                alt="{{ $product['name'] }} - Foto {{ $index + 1 }}"
                                loading="lazy"
                            >

                        </button>

                    @endforeach

                </div>

            @endif

        </div>


        {{-- RIGHT: PRODUCT INFORMATION --}}
        <div class="product-detail-info">

            <div class="product-detail-info-top">

                <a
                    href="{{ route('store.index') }}"
                    class="product-detail-back"
                >
                    ← Return to Catalog
                </a>

                <div class="product-detail-title-row">

                    <h1>{{ $product['name'] }}</h1>

                    <span class="product-detail-type-badge">
                        {{ $typeLabel }}
                    </span>

                </div>

                <div class="product-detail-description">
                    <p>{{ $product['description'] }}</p>
                </div>

                            {{-- PRODUCT CATEGORY --}}
            <div class="product-detail-category">
                <span>Kategori:</span>
                <strong>{{ $product['category'] ?? '-' }}</strong>
            </div>

            </div>


            {{-- ORDER BUTTON --}}
            @if ($product['availability'] !== 'Tidak Tersedia')

                <a
                    class="product-detail-order"
                    href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode($whatsappMessage) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                >
                    Order Here
                    <span aria-hidden="true">›</span>
                </a>

            @else

                <span class="product-detail-unavailable">
                    Tidak tersedia untuk dipesan
                </span>

            @endif

        </div>

    </div>

</section>

@endsection
