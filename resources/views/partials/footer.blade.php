
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

                <a href="{{ config('cakrawala.social.instagram', 'https://instagram.com/cakrawalageosurvey') }}"
                   aria-label="Instagram">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="none" stroke="currentColor" stroke-width="2"
                              d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Z"/>
                        <circle cx="12" cy="12" r="4" fill="none"
                                stroke="currentColor" stroke-width="2"/>
                        <circle cx="18" cy="6" r="1.2" fill="currentColor"/>
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
