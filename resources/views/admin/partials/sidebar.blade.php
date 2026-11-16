
<aside class="admin-sidebar">

    {{-- HEADER --}}
    <div class="admin-sidebar-header">
        <a class="admin-sidebar-brand" href="{{ route('admin.dashboard') }}">
            <img
                src="{{ asset('images/logo/logo-cakrawalageosurvey.jpg') }}"
                alt="Cakrawala Geosurvey"
            >
        </a>

        <span class="admin-sidebar-title">Halaman Admin</span>
    </div>

    {{-- NAVIGATION --}}
    <nav class="admin-sidebar-nav">

        <a
            href="{{ route('admin.dashboard') }}"
            class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'admin-nav-link-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1"/>
                <rect x="14" y="3" width="7" height="7" rx="1"/>
                <rect x="3" y="14" width="7" height="7" rx="1"/>
                <rect x="14" y="14" width="7" height="7" rx="1"/>
            </svg>
            <span>Dashboard</span>
        </a>

        <p class="admin-sidebar-label">Workspace</p>

        <a
            href="{{ route('admin.contact.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.contact.*') ? 'admin-nav-link-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <path d="m3 7 9 6 9-6"/>
            </svg>
            <span>Kontak</span>
        </a>

        <a
            href="{{ route('admin.services.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.services.*') ? 'admin-nav-link-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="9"/>
                <path d="M12 8v8M8 12h8"/>
            </svg>
            <span>Layanan</span>
        </a>

        <a
            href="{{ route('admin.products.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.products.*') ? 'admin-nav-link-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9h18l-2 11H5L3 9Z"/>
                <path d="M8 9l4-6 4 6"/>
                <path d="M9 14h6"/>
            </svg>
            <span>Katalog</span>
        </a>

        <a
            href="{{ route('admin.mitra.index') }}"
            class="admin-nav-link {{ request()->routeIs('admin.mitra.*') ? 'admin-nav-link-active' : '' }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
            <span>Mitra</span>
        </a>

        <a href="{{ route('home') }}" target="_blank" class="admin-nav-link">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 3h7v7"/>
                <path d="M10 14 21 3"/>
                <path d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5"/>
            </svg>
            <span>Lihat website</span>
        </a>

    </nav>

    {{-- PROFILE & LOGOUT --}}
    <div class="admin-sidebar-bottom">

        <div class="admin-sidebar-profile">

            <div class="admin-profile-avatar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="3.5"/>
                    <path d="M5 20c0-3.5 3-6 7-6s7 2.5 7 6"/>
                    <circle cx="12" cy="12" r="10"/>
                </svg>
            </div>

            <div class="admin-profile-info">
                <span class="admin-profile-name">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>
                <span class="admin-profile-role">Administrator</span>
            </div>

            <svg class="admin-profile-chevron" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <path d="m9 18 6-6-6-6"/>
            </svg>

        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <button class="admin-logout" type="submit">
                <span>Log Out</span>

                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10 17l5-5-5-5"/>
                    <path d="M15 12H3"/>
                    <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                </svg>
            </button>
        </form>

    </div>

</aside>
