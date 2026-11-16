
@if ($errors->any())
    <div class="admin-contact-errors" role="alert">
        <div class="admin-contact-error-icon">!</div>

        <div>
            <strong>Data kontak belum bisa disimpan</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="admin-contact-form-grid">

    {{-- Nama --}}
    <div class="admin-contact-form-field @error('name') has-error @enderror">
        <label for="name">
            Nama Lengkap
            <span>*</span>
        </label>

        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $contact->name ?? '') }}"
            placeholder="Masukkan nama kontak"
            autocomplete="name"
            required
        >

        @error('name')
            <p class="admin-contact-field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div class="admin-contact-form-field @error('email') has-error @enderror">
        <label for="email">
            Email
            <span>*</span>
        </label>

        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $contact->email ?? '') }}"
            placeholder="contoh@email.com"
            autocomplete="email"
            required
        >

        @error('email')
            <p class="admin-contact-field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- WhatsApp --}}
    <div class="admin-contact-form-field @error('no_hp') has-error @enderror">
        <label for="no_hp">
            Nomor WhatsApp
            <span>*</span>
        </label>

        <input
            id="no_hp"
            name="no_hp"
            type="tel"
            value="{{ old('no_hp', $contact->no_hp ?? '+62 ') }}"
            placeholder="+62 812 3456 7890"
            inputmode="numeric"
            autocomplete="tel"
            maxlength="17"
            pattern="\+62\s\d{3}\s\d{4}\s\d{4}"
            data-phone-input
            required
        >

        <small>
            Gunakan nomor WhatsApp aktif. Format akan disesuaikan otomatis.
        </small>

        @error('no_hp')
            <p class="admin-contact-field-error">{{ $message }}</p>
        @enderror
    </div>

    {{-- Alamat --}}
    <div class="admin-contact-form-field @error('alamat') has-error @enderror">
        <label for="alamat">
            Alamat
            <span>*</span>
        </label>

        <textarea
            id="alamat"
            name="alamat"
            rows="3"
            placeholder="Masukkan alamat perusahaan"
            autocomplete="street-address"
            required
        >{{ old('alamat', $contact->alamat ?? '') }}</textarea>

        @error('alamat')
            <p class="admin-contact-field-error">{{ $message }}</p>
        @enderror
    </div>

</div>

<div class="admin-contact-form-footer">

    <a
        href="{{ route('admin.contact.index') }}"
        class="admin-contact-cancel"
    >
        Batal
    </a>

    <button
        class="admin-contact-submit"
        type="submit"
    >
        <span>Simpan Kontak</span>
        <span aria-hidden="true">→</span>
    </button>

</div>
