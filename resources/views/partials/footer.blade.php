
<footer class="site-footer">
        {{-- COMPANY LOCATION MAP --}}
    <section class="footer-map-section" aria-label="Lokasi perusahaan">

        <div class="container footer-map-container">

            <iframe
                src="https://www.google.com/maps?q=Bali+Cakrawala+Geosurvey,+Gg.+Gumuk+Sari+No.18b,+Sesetan,+Denpasar+Selatan,+Denpasar+City,+Bali+80225&output=embed"
                width="100%"
                height="320"
                style="border:0"
                loading="lazy"
                allowfullscreen
                referrerpolicy="no-referrer-when-downgrade"
                title="Lokasi Bali Cakrawala Geosurvey di Google Maps">
            </iframe>

            <a
                href="https://maps.app.goo.gl/WT58mWdj6HNm3iKX8?g_st=iw"
                target="_blank"
                rel="noopener noreferrer"
                class="footer-map-link"
            >
                Lihat Lokasi di Google Maps
                <span aria-hidden="true">↗</span>
            </a>

        </div>

    </section>

    <div class="container footer-main">

        {{-- Brand Information --}}
        <div class="footer-brand-block">
            <a class="footer-brand-title" href="{{ route('home') }}">
                {{ strtoupper(config('cakrawala.brand.name', 'Cakrawala Geosurvey')) }}
            </a>

            <p class="footer-description">
                Stay connected with us to receive the latest updates on surveying services, mapping solutions, and project developments from Cakrawala Geosurvey.
            </p>

            {{-- Social Media --}}
            <div class="footer-socials">

                <a href="{{ config('cakrawala.social.facebook', '#') }}"
                   aria-label="Facebook">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.413c0-3.03 1.792-4.704 4.533-4.704 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.49 0-1.956.93-1.956 1.885v2.273h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
                    </svg>
                </a>

                <a href="{{ config('cakrawala.social.instagram', '#') }}"
                   aria-label="Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="none" stroke="currentColor" stroke-width="2"
                              d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Z"/>
                        <circle cx="12" cy="12" r="4" fill="none"
                                stroke="currentColor" stroke-width="2"/>
                        <circle cx="18" cy="6" r="1.2" fill="currentColor"/>
                    </svg>
                </a>

                <a href="{{ config('cakrawala.social.twitter', '#') }}"
                   aria-label="Twitter">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="currentColor" d="M23.953 4.57a10 10 0 0 1-2.825.775 4.932 4.932 0 0 0 2.163-2.723 9.99 9.99 0 0 1-3.127 1.195 4.916 4.916 0 0 0-8.384 4.482A13.94 13.94 0 0 1 1.64 2.162a4.916 4.916 0 0 0 1.523 6.56 4.9 4.9 0 0 1-2.229-.616v.062a4.92 4.92 0 0 0 3.946 4.818 4.93 4.93 0 0 1-2.224.084 4.927 4.927 0 0 0 4.6 3.419A9.87 9.87 0 0 1 0 20.54a13.93 13.93 0 0 0 7.548 2.213c9.057 0 14.01-7.503 14.01-14.01 0-.213-.005-.425-.014-.636a10 10 0 0 0 2.46-2.548z"/>
                    </svg>
                </a>

            </div>
        </div>

        {{-- Company Information --}}
        <div class="footer-column">
            <h2>About Us</h2>

            <a href="{{ route('home') }}#documentation">
                Documentation
            </a>
            <a href="{{ route('home') }}#mitra">
                Our Partners
            </a>
            <a href="{{ route('services.index') }}">Services</a>
        </div>

        {{-- Catalog --}}
        <div class="footer-column">
            <h2>Catalog</h2>

            <a href="{{ route('store.index') }}">Rent</a>
            <a href="{{ route('store.index') }}">Buy Sell</a>
        </div>

        <!-- <div class="footer-column footer-contact">
            <h2>Contact</h2>
            <p>{{ $contact['address'] }}</p>
            <a href="{{ route('contact') }}" class="footer-contact-link">Contact our team <span aria-hidden="true">→</span></a>
        </div> -->
    </div>
    <!-- <div class="footer-bottom">
        <div class="container footer-bottom-inner">
            <p>© {{ date('Y') }} {{ config('cakrawala.brand.name') }}. All rights reserved.</p>
            <p class="demo-note">Initial frontend skeleton · Sample content</p>
        </div>
    </div> -->
</footer>
