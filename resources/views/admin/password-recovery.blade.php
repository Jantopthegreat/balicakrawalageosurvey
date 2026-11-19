<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.partials.favicon')
    <title>{{ $reset ? 'Reset Password' : 'Lupa Password' }} | {{ config('cakrawala.brand.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-body">
    <main class="admin-login-page">
        <section class="admin-login-visual" style="background-image: url('{{ asset('images/hero/herolandscape.png') }}');">
            <div class="admin-visual-overlay"></div>
            <a href="{{ route('home') }}" class="admin-visual-brand">
                <img src="{{ asset('images/logo/logo-cakrawalageosurvey.jpg') }}" alt="Cakrawala Geosurvey">
            </a>
            <div class="admin-visual-content">
                <p class="admin-visual-kicker">Pemulihan Akun Admin</p>
                <h1>Cakrawala<br>Geosurvey</h1>
                <p class="admin-visual-description">Pulihkan akses akun Anda dan kembali kelola website.</p>
                <span class="admin-visual-line"></span>
            </div>
            <div class="admin-visual-footer">&copy; {{ date('Y') }} Cakrawala Geosurvey</div>
        </section>
        <section class="admin-login-content">
            <div class="admin-login-card">
                <div class="admin-login-header">
                    <h2>{{ $reset ? 'Buat Password Baru' : 'Lupa Password?' }}</h2>
                    <p>{{ $reset ? 'Masukkan password baru untuk akun admin Anda.' : 'Masukkan email akun admin untuk menerima tautan reset password.' }}</p>
                </div>
                @if (session('status'))
                    <p class="admin-password-success" role="status">{{ session('status') }}</p>
                @endif
                @if ($errors->any())
                    <div class="admin-alert" role="alert">{{ $errors->first() }}</div>
                @endif
                <form class="admin-form" method="POST" action="{{ route($reset ? 'admin.password.reset.store' : 'admin.password.email') }}">
                    @csrf
                    @if ($reset)
                        <input type="hidden" name="token" value="{{ $token }}">
                    @endif
                    <div class="admin-form-group">
                        <label for="email">Email admin</label>
                        <input type="email" id="email" name="email" value="{{ $reset ? $email : old('email') }}" autocomplete="email" required @if ($reset) readonly @else autofocus @endif>
                    </div>
                    @if ($reset)
                        <div class="admin-form-group">
                            <label for="password">Password baru</label>
                            <input type="password" id="password" name="password" autocomplete="new-password" minlength="8" maxlength="72" aria-describedby="password-hint" required autofocus>
                            <small id="password-hint">Gunakan 8–72 karakter.</small>
                        </div>
                        <div class="admin-form-group">
                            <label for="password_confirmation">Konfirmasi password baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" minlength="8" maxlength="72" required>
                        </div>
                    @endif
                    <button class="admin-button" type="submit">{{ $reset ? 'Simpan Password Baru' : 'Kirim Tautan Reset' }}</button>
                </form>
                <div class="admin-login-divider"></div>
                <p class="admin-login-help"><a href="{{ route('admin.login') }}">Kembali ke login</a></p>
                @if ($reset)
                    <p class="admin-login-help"><a href="{{ route('admin.password.request') }}">Minta tautan reset baru</a></p>
                @endif
            </div>
        </section>
    </main>
</body>
</html>
