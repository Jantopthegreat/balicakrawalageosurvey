
@props(['product'])

@php
    $type = $product['type'] ?? '';
    $badge = $type === 'rent' ? 'Sewa' : ($type === 'sale' ? 'Jual' : null);
@endphp

<article class="catalog-product-card">

    {{-- PRODUCT IMAGE --}}
    <a
        class="catalog-product-image"
        href="{{ route('store.show', $product['slug']) }}"
        aria-label="Lihat {{ $product['name'] }}"
    >
        <img
            src="{{ asset($product['image'] ?? 'images/products/product-placeholder.svg') }}"
            alt="{{ $product['name'] }}"
            loading="lazy"
        >

        @if ($badge)
            <span class="catalog-product-badge">
                {{ $badge }}
            </span>
        @endif
    </a>

    {{-- PRODUCT INFORMATION --}}
    <div class="catalog-product-body">

        <h3>
            {{ $product['name'] }}
        </h3>

        <p class="catalog-product-description">
            {{ $product['description'] }}
        </p>

        <a
            href="{{ route('store.show', $product['slug']) }}"
            class="catalog-product-order"
        >
            Order Here
            <span aria-hidden="true">›</span>
        </a>

    </div>

</article>
