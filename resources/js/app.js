document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-menu-toggle]');
    const nav = document.querySelector('[data-main-nav]');

    if (!toggle || !nav) return;

    const closeMenu = () => {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Open navigation');
        nav.classList.remove('is-open');
    };

    toggle.addEventListener('click', () => {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        toggle.setAttribute('aria-expanded', String(!isOpen));
        toggle.setAttribute('aria-label', isOpen ? 'Open navigation' : 'Close navigation');
        nav.classList.toggle('is-open', !isOpen);
    });

    nav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeMenu();
            nav.querySelectorAll('details[open]').forEach((dropdown) => dropdown.removeAttribute('open'));
        }
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 860) closeMenu();
    });
});

// Scroll reveal animation
document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".reveal");

    if (!elements.length) return;

    const prefersReducedMotion = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;

    if (
        prefersReducedMotion ||
        !("IntersectionObserver" in window)
    ) {
        elements.forEach((element) => {
            element.classList.add("is-visible");
        });

        return;
    }

    document.documentElement.classList.add("js-reveal");

    const observer = new IntersectionObserver(
        (entries, observer) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("is-visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        {
            threshold: 0.12,
            rootMargin: "0px 0px -40px 0px",
        }
    );

    elements.forEach((element) => {
        observer.observe(element);
    });
});


/* =====================================
   HOMEPAGE SERVICE SLIDER
===================================== */

function initHomeServiceSlider() {

    const slider = document.querySelector('[data-service-slider]');

    if (!slider || slider.dataset.initialized === 'true') {
        return;
    }

    slider.dataset.initialized = 'true';

    const slides = Array.from(
        slider.querySelectorAll('[data-service-slide]')
    );

    const dots = Array.from(
        slider.querySelectorAll('[data-service-dot]')
    );

    if (slides.length <= 1) {
        return;
    }

    let currentIndex = slides.findIndex(
        slide => slide.classList.contains('is-active')
    );

    if (currentIndex < 0) {
        currentIndex = 0;
    }

    let autoplayTimer = null;

    const interval = Math.max(
        2000,
        Number(slider.dataset.interval) || 5000
    );

    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;


    // Change active slide
    function showSlide(index) {

        currentIndex = (index + slides.length) % slides.length;

        slides.forEach((slide, i) => {

            const isActive = i === currentIndex;

            slide.classList.toggle('is-active', isActive);
            slide.setAttribute('aria-hidden', String(!isActive));

            const link = slide.querySelector('.home-service-slide-link');

            if (link) {
                link.tabIndex = isActive ? 0 : -1;
            }

        });

        dots.forEach((dot, i) => {

            const isActive = i === currentIndex;

            dot.classList.toggle('is-active', isActive);
            dot.setAttribute('aria-pressed', String(isActive));

        });

    }


    // Next slide
    function nextSlide() {
        showSlide(currentIndex + 1);
    }


    // Stop autoplay
    function stopAutoplay() {

        if (autoplayTimer !== null) {
            window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        }

    }


    // Start autoplay
    function startAutoplay() {

        stopAutoplay();

        if (prefersReducedMotion || document.hidden) {
            return;
        }

        autoplayTimer = window.setInterval(
            nextSlide,
            interval
        );

    }


    // Click on indicators
    dots.forEach((dot, index) => {

        dot.addEventListener('click', () => {

            showSlide(index);

            // Restart interval after manual selection
            startAutoplay();

        });

    });


    // Pause when user hovers over slider
    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);


    // Pause when slider receives keyboard focus
    slider.addEventListener('focusin', stopAutoplay);

    slider.addEventListener('focusout', event => {

        if (!slider.contains(event.relatedTarget)) {
            startAutoplay();
        }

    });


    // Pause when browser tab is not visible
    document.addEventListener('visibilitychange', () => {

        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }

    });


    // Initialize
    showSlide(currentIndex);
    startAutoplay();

}


// Initialize after page is ready
if (document.readyState === 'loading') {

    document.addEventListener(
        'DOMContentLoaded',
        initHomeServiceSlider,
        { once: true }
    );

} else {

    initHomeServiceSlider();

}


/* =====================================
   HOMEPAGE DOCUMENTATION CAROUSELS
===================================== */

function initDocumentationCarousels() {
    const carousels = document.querySelectorAll(
        '[data-documentation-carousel]'
    );

    carousels.forEach((slider) => {
        if (slider.dataset.initialized === 'true') {
            return;
        }

        slider.dataset.initialized = 'true';

        const slides = Array.from(
            slider.querySelectorAll('[data-documentation-slide]')
        );

        const dots = Array.from(
            slider.querySelectorAll('[data-documentation-dot]')
        );

        if (slides.length === 0) {
            return;
        }

        let currentIndex = slides.findIndex(
            (slide) => slide.classList.contains('is-active')
        );

        if (currentIndex < 0) {
            currentIndex = 0;
        }

        let autoplayTimer = null;

        const interval = Math.max(
            2000,
            Number(slider.dataset.interval) || 5500
        );

        const prefersReducedMotion = window.matchMedia(
            '(prefers-reduced-motion: reduce)'
        ).matches;

        // Change active photo
        function showSlide(index) {
            currentIndex = (index + slides.length) % slides.length;

            slides.forEach((slide, i) => {
                const isActive = i === currentIndex;

                slide.classList.toggle('is-active', isActive);
                slide.setAttribute('aria-hidden', String(!isActive));
            });

            dots.forEach((dot, i) => {
                const isActive = i === currentIndex;

                dot.classList.toggle('is-active', isActive);
                dot.setAttribute('aria-pressed', String(isActive));
            });
        }

        // Stop autoplay
        function stopAutoplay() {
            if (autoplayTimer !== null) {
                window.clearInterval(autoplayTimer);
                autoplayTimer = null;
            }
        }

        // Start autoplay
        function startAutoplay() {
            stopAutoplay();

            if (
                prefersReducedMotion ||
                document.hidden ||
                slides.length <= 1
            ) {
                return;
            }

            autoplayTimer = window.setInterval(() => {
                showSlide(currentIndex + 1);
            }, interval);
        }

        // Manual navigation using dots
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                showSlide(index);
                startAutoplay();
            });
        });

        // Pause when hovering
        slider.addEventListener('mouseenter', stopAutoplay);
        slider.addEventListener('mouseleave', startAutoplay);

        // Pause when focused
        slider.addEventListener('focusin', stopAutoplay);

        slider.addEventListener('focusout', (event) => {
            if (!slider.contains(event.relatedTarget)) {
                startAutoplay();
            }
        });

        // Pause when browser tab is hidden
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoplay();
            } else {
                startAutoplay();
            }
        });

        // Initialize carousel
        showSlide(currentIndex);
        startAutoplay();
    });
}

// Initialize after page is ready
if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initDocumentationCarousels,
        { once: true }
    );
} else {
    initDocumentationCarousels();
}



/* =====================================
   MITRA BATCH CAROUSEL
===================================== */

function initMitraCarousel() {
    const grid = document.querySelector('[data-mitra-carousel]');

    if (!grid || grid.dataset.initialized === 'true') {
        return;
    }

    const items = Array.from(
        grid.querySelectorAll('[data-mitra-item]')
    );

    if (items.length === 0) return;

    const batchSize = 6;

    const enterStagger = 100;
    const exitStagger = 80;

    const transitionDuration = 650;
    const displayDuration = 4500;

    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    /* =====================================
       REDUCED MOTION
    ===================================== */

    if (prefersReducedMotion) {
        items.forEach(item => {
            item.hidden = false;
            item.style.opacity = '1';
            item.style.transform = 'none';
        });

        return;
    }

    /* =====================================
       INITIALIZATION
    ===================================== */

    grid.dataset.initialized = 'true';
    grid.classList.add('is-carousel-ready');

    let currentBatch = 0;
    let started = false;

    const totalBatches = Math.ceil(
        items.length / batchSize
    );

    /* =====================================
       GET CURRENT BATCH
    ===================================== */

    function getBatch(batchIndex) {
        const startIndex = batchIndex * batchSize;

        return items.slice(
            startIndex,
            startIndex + batchSize
        );
    }

    /* =====================================
       SHOW BATCH
    ===================================== */

    function showBatch() {
        const batch = getBatch(currentBatch);

        // Reset all items
        items.forEach(item => {
            item.classList.remove(
                'is-visible',
                'is-exiting'
            );

            item.hidden = true;
            item.style.transitionDelay = '0ms';
        });

        // Prepare active batch
        batch.forEach((item, index) => {
            item.hidden = false;

            item.style.transitionDelay =
                `${index * enterStagger}ms`;
        });

        // Trigger entrance animation
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                batch.forEach(item => {
                    item.classList.add('is-visible');
                });
            });
        });

        // Calculate entrance duration
        const enterDuration =
            transitionDuration +
            (batch.length - 1) * enterStagger;

        // Keep batch visible before exiting
        setTimeout(() => {
            hideBatch(batch);
        }, enterDuration + displayDuration);
    }

    /* =====================================
       HIDE BATCH
    ===================================== */

    function hideBatch(batch) {
        batch.forEach((item, index) => {
            item.style.transitionDelay =
                `${index * exitStagger}ms`;

            item.classList.remove('is-visible');
            item.classList.add('is-exiting');
        });

        const exitDuration =
            transitionDuration +
            (batch.length - 1) * exitStagger;

        setTimeout(() => {
            batch.forEach(item => {
                item.hidden = true;

                item.classList.remove('is-exiting');

                item.style.transitionDelay = '0ms';
            });

            // Move to next batch
            currentBatch = (currentBatch + 1) % totalBatches;

            showBatch();

        }, exitDuration);
    }

    /* =====================================
       START ANIMATION
    ===================================== */

    function startCarousel() {
        if (started) return;

        started = true;

        showBatch();
    }

    /* =====================================
       INTERSECTION OBSERVER
    ===================================== */

    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(
            entries => {
                if (entries.some(entry => entry.isIntersecting)) {
                    startCarousel();

                    observer.disconnect();
                }
            },
            {
                threshold: 0.05
            }
        );

        observer.observe(grid);

    } else {
        startCarousel();
    }
}

/* =====================================
   INITIALIZE
===================================== */

if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initMitraCarousel,
        { once: true }
    );
} else {
    initMitraCarousel();
}


/* =====================================
   INDONESIAN WHATSAPP NUMBER FORMATTER
===================================== */

document.addEventListener('DOMContentLoaded', () => {

    const phoneInputs = document.querySelectorAll(
        '[data-phone-input]'
    );

    phoneInputs.forEach((input) => {

        // Format Indonesian phone number
        function formatPhone(value) {

            let digits = value.replace(/\D/g, '');

            // Remove country code if already present
            if (digits.startsWith('62')) {
                digits = digits.slice(2);
            }

            // Convert local prefix 0 to country code +62
            else if (digits.startsWith('0')) {
                digits = digits.slice(1);
            }

            // Maximum 11 digits after +62
            digits = digits.slice(0, 11);

            const groups = [];

            if (digits.length > 0) {
                groups.push(digits.slice(0, 3));
            }

            if (digits.length > 3) {
                groups.push(digits.slice(3, 7));
            }

            if (digits.length > 7) {
                groups.push(digits.slice(7, 11));
            }

            return '+62 ' + groups.join(' ');
        }

        // Format existing value when opening form
        input.value = formatPhone(input.value);

        // Format while typing
        input.addEventListener('input', () => {
            input.value = formatPhone(input.value);

            // Keep cursor at the end
            input.setSelectionRange(
                input.value.length,
                input.value.length
            );
        });

        // Prevent deleting the +62 prefix
        input.addEventListener('keydown', (event) => {

            if (
                event.key === 'Backspace' &&
                input.selectionStart <= 4
            ) {
                event.preventDefault();
            }

            if (
                event.key === 'Delete' &&
                input.selectionStart < 4
            ) {
                event.preventDefault();
            }

        });

        // Always restore prefix when empty
        input.addEventListener('blur', () => {
            if (!input.value.trim()) {
                input.value = '+62 ';
            }
        });

    });

});


/* =====================================
   PRODUCT DETAIL IMAGE CAROUSEL
===================================== */

function initProductGallery() {
    const gallery = document.querySelector('[data-product-gallery]');

    if (!gallery || gallery.dataset.initialized === 'true') {
        return;
    }

    const mainImage = gallery.querySelector(
        '[data-product-main-image]'
    );

    const thumbnails = Array.from(
        gallery.querySelectorAll('[data-product-thumbnail]')
    );

    if (!mainImage || thumbnails.length === 0) {
        return;
    }

    gallery.dataset.initialized = 'true';

    let currentIndex = 0;
    let autoplayTimer = null;
    let changeTimer = null;

    const interval = Math.max(
        2000,
        Number(gallery.dataset.interval) || 4500
    );

    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    function showImage(index) {
        currentIndex = (index + thumbnails.length) % thumbnails.length;

        const activeThumbnail = thumbnails[currentIndex];
        const thumbnailImage = activeThumbnail.querySelector('img');

        const imageSource = thumbnailImage.getAttribute('src');

        // Update active thumbnail
        thumbnails.forEach((thumbnail, i) => {
            const isActive = i === currentIndex;

            thumbnail.classList.toggle('is-active', isActive);
            thumbnail.setAttribute('aria-pressed', String(isActive));
        });

        // Fade transition
        mainImage.classList.add('is-changing');

        if (changeTimer) {
            window.clearTimeout(changeTimer);
        }

        changeTimer = window.setTimeout(() => {
            mainImage.src = imageSource;
            mainImage.alt = thumbnailImage.alt;

            requestAnimationFrame(() => {
                mainImage.classList.remove('is-changing');
            });
        }, 180);
    }

    function stopAutoplay() {
        if (autoplayTimer !== null) {
            window.clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    function startAutoplay() {
        stopAutoplay();

        if (
            prefersReducedMotion ||
            document.hidden ||
            thumbnails.length <= 1
        ) {
            return;
        }

        autoplayTimer = window.setInterval(() => {
            showImage(currentIndex + 1);
        }, interval);
    }

    // Thumbnail click
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => {
            showImage(index);
            startAutoplay();
        });
    });

    // Pause on hover
    gallery.addEventListener('mouseenter', stopAutoplay);
    gallery.addEventListener('mouseleave', startAutoplay);

    // Pause when keyboard focus is inside gallery
    gallery.addEventListener('focusin', stopAutoplay);

    gallery.addEventListener('focusout', (event) => {
        if (!gallery.contains(event.relatedTarget)) {
            startAutoplay();
        }
    });

    // Pause when browser tab is hidden
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });

    // Initialize
    const initialIndex = thumbnails.findIndex(
        thumbnail => thumbnail.classList.contains('is-active')
    );

    currentIndex = initialIndex >= 0 ? initialIndex : 0;

    startAutoplay();
}

// Initialize after DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener(
        'DOMContentLoaded',
        initProductGallery,
        { once: true }
    );
} else {
    initProductGallery();
}

