
@if (!empty($mitra))
    <section class="mitra-preview section section-muted" id="mitra">

        <div class="container">

            <div class="mitra-preview-layout">

                {{-- Left: Heading and Description --}}
                <div class="section-heading mitra-preview-heading">
                    <h2 class="section-title">
                        Dipercaya oleh berbagai mitra
                    </h2>

                    <p class="section-description">
                        Kolaborasi dan kepercayaan menjadi bagian
                        penting dalam setiap proyek kami.
                        Bersama mitra terpercaya, kami berkomitmen
                        memberikan hasil survei dan pemetaan
                        geospasial berkualitas.
                    </p>

                </div>

                {{-- Right: Partner Logos --}}
                <div class="mitra-preview-grid" data-mitra-carousel>

                    @foreach ($mitra as $partner)
                        <article
                            class="mitra-preview-card"
                            data-mitra-item
                        >

                            @if ($partner['image'])
                                <img
                                    src="{{ $partner['image'] }}"
                                    alt="Logo {{ $partner['name'] }}"
                                    loading="lazy"
                                >
                            @else
                                <span
                                    class="mitra-preview-placeholder"
                                    aria-hidden="true"
                                >
                                    {{ mb_substr($partner['name'], 0, 1) }}
                                </span>
                            @endif

                        </article>
                    @endforeach

                </div>

            </div>

        </div>

    </section>
@endif
