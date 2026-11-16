@extends('layouts.app')

@section('title', $product['name'] . ' | CAKRAWALA Store')
@section('meta_description', $product['description'])

@section('content')
    <section class="section product-detail-section {{ $product['availability'] === 'Tidak Tersedia' ? 'product-detail-unavailable' : '' }}"><div class="container product-detail-grid"><div class="product-detail-image"><img src="{{ $product['image'] }}" alt="{{ $product['name'] }}"><div class="product-detail-gallery">@foreach ($product['images'] as $image)<img src="{{ $image }}" alt="{{ $product['name'] }}" loading="lazy">@endforeach</div></div><div class="product-detail-copy"><a class="back-link" href="{{ route('store.index') }}">← Back to store</a><p class="eyebrow">{{ $product['category'] }}</p><h1>{{ $product['name'] }}</h1><p class="detail-lead">{{ $product['description'] }}</p><p class="availability-label">{{ $product['availability'] }}</p><p class="small-note">This is a sample product entry. Confirm product specifications and price with the client before publishing.</p>
    @php($whatsappMessage = 'Hello Cakrawala, I would like to ask about ' . $product['name'] . '.')
    @if ($product['availability'] === 'Tidak Tersedia')
        <span class="button button-disabled">Tidak tersedia untuk dipesan</span>
    @else
        <a class="button button-primary" href="https://wa.me/{{ preg_replace('/\D+/', '', config('cakrawala.contact.whatsapp')) }}?text={{ rawurlencode($whatsappMessage) }}" target="_blank" rel="noopener noreferrer">Enquire via WhatsApp <span aria-hidden="true">↗</span></a>
    @endif
    </div></div></section>
@endsection
