@extends('admin.layout')

@section('title', 'Ubah Password')

@section('content')
<div class="admin-dashboard">
    <header class="admin-dashboard-header">
        <div class="admin-dashboard-title"><h1>Ubah Password</h1></div>
        <p>Perbarui password akun admin Anda.</p>
    </header>

    <section class="admin-password-card">
        @if (session('status'))
            <p class="admin-password-success" role="status">{{ session('status') }}</p>
        @endif

        <form action="{{ route('admin.password.update') }}" method="POST" class="admin-password-form">
            @csrf
            @method('PUT')

            @foreach (['current_password' => 'Password lama', 'password' => 'Password baru', 'password_confirmation' => 'Konfirmasi password baru'] as $field => $label)
                <div class="admin-password-field">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <input id="{{ $field }}" name="{{ $field }}" type="password" required
                        autocomplete="{{ $field === 'current_password' ? 'current-password' : 'new-password' }}"
                        @if ($field !== 'current_password') minlength="8" maxlength="72" @endif
                        @if ($field === 'password') aria-describedby="password-hint{{ $errors->has($field) ? ' password-error' : '' }}"
                        @elseif ($errors->has($field)) aria-describedby="{{ $field }}-error" @endif
                        @error($field) aria-invalid="true" @enderror>
                    @if ($field === 'password')
                        <small id="password-hint">Gunakan 8–72 karakter dan password yang berbeda dari password lama.</small>
                    @endif
                    @error($field)
                        <p id="{{ $field }}-error" class="admin-password-error" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach

            <div class="admin-password-actions">
                <a href="{{ route('admin.dashboard') }}" class="admin-mitra-cancel">Batal</a>
                <button type="submit" class="admin-mitra-submit">Simpan Password</button>
            </div>
        </form>
    </section>
</div>
@endsection
