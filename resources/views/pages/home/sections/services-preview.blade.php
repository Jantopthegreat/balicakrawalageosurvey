
    <section class="home-services" id="services">

        {{-- Section Heading --}}
        <div class="home-services-heading">
            <div class="container">
                <h2>Layanan</h2>
            </div>
        </div>

        <div class="home-services-content">
            <div class="container">

                {{-- Section Introduction --}}
                <div class="home-services-intro reveal">

                    <p>
                       With the support of a skilled and experienced team, combined with advanced surveying technology and modern equipment, we provide a comprehensive range of services, including Topographic Surveys, Land Surveys, Geodetic Surveys, UAV Mapping, Aerial Photogrammetry, Bathymetric Surveys, and other geospatial solutions.
                    </p>

                    <a href="{{ route('services.index') }}"
                    class="home-services-button">
                        Layanan
                    </a>

                </div>

                {{-- Automatic Image Slider --}}
{{-- Automatic Image Slider --}}
<x-service-slider :slides="$serviceSlides" />

            </div>
        </div>

    </section>
