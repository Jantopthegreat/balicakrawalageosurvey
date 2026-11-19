
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login Admin | {{ config('cakrawala.brand.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="admin-body">

    <main class="admin-login-page">

        {{-- LEFT PANEL --}}
        <section
    class="admin-login-visual"
    style="background-image: url('{{ asset('images/hero/herolandscape.png') }}');"
>

               <div class="admin-visual-overlay"></div>


            <a href="{{ route('home') }}" class="admin-visual-brand">
                {{-- Sesuaikan path logo dengan file logo kamu --}}
                <img src="{{ asset('images\logo\logo-cakrawalageosurvey.jpg') }}"
                     alt="Cakrawala Geosurvey">
            </a>

            <div class="admin-visual-content">

                <p class="admin-visual-kicker">
                    Selamat Datang di Halaman Login sebagai Admin
                </p>

                <h1>
                    Cakrawala<br>
                    Geosurvey
                </h1>

                <p class="admin-visual-description">
                    A secure, organized, and consistent platform
                    for your team to operate with confidence.
                </p>

                <span class="admin-visual-line"></span>

            </div>

            <div class="admin-visual-footer">
                © {{ date('Y') }} Cakrawala Geosurvey
            </div>

        </section>


        {{-- RIGHT PANEL --}}
        <section class="admin-login-content">

            <div class="admin-login-card">

                <div class="admin-login-header">

                    <h2>Masukkan Email Anda</h2>

                    <p>
                        Silakan masuk menggunakan akun administrator
                        untuk melanjutkan.
                    </p>
                </div>


                {{-- ERROR MESSAGE --}}
                @if ($errors->any())
                    <div class="admin-alert" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif


                {{-- LOGIN FORM --}}
                <form
                    class="admin-form"
                    method="POST"
                    action="{{ route('admin.login.store') }}"
                >
                    @csrf

                    <div class="admin-form-group">
                        <label for="email">Email</label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="admin@example.com"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>


                    <div class="admin-form-group">
                        <label for="password">Password</label>

                        <div class="admin-password-wrapper">
                            <input
                                id="password"
                                name="password"
                                type="password"
                                placeholder="Masukkan Password"
                                autocomplete="current-password"
                                required
                            >

                            <button
                                type="button"
                                class="admin-password-toggle"
                                aria-label="Tampilkan password"
                                aria-pressed="false"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>


                    <div class="admin-form-hint">
                        Pastikan email dan password yang dimasukkan
                        sudah benar sebelum login.
                    </div>


                    <label class="admin-remember">
                        <input
                            type="checkbox"
                            name="remember"
                            value="1"
                        >
                        <span>Ingat saya</span>
                    </label>


                    <button type="submit" class="admin-button">
                        Login
                    </button>

                </form>


                <div class="admin-login-divider"></div>

                <p class="admin-login-help">
                    Having trouble? Contact your administrator.
                </p>

            </div>

        </section>

    </main>

    <script>
        const toggle = document.querySelector('.admin-password-toggle');
        const password = document.querySelector('#password');

        toggle?.addEventListener('click', () => {
            const isPassword = password.type === 'password';

            password.type = isPassword ? 'text' : 'password';

            toggle.setAttribute(
                'aria-pressed',
                String(isPassword)
            );

            toggle.setAttribute(
                'aria-label',
                isPassword ? 'Sembunyikan password' : 'Tampilkan password'
            );
        });
    </script>

</body>
</html>
