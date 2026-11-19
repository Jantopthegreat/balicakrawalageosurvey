
@if ($errors->any())
    <div class="admin-mitra-errors" role="alert">
        <div class="admin-mitra-error-icon">!</div>

        <div>
            <strong>Data mitra belum bisa disimpan</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="admin-mitra-form-grid">

    {{-- NAMA MITRA --}}
    <div class="admin-mitra-form-field @error('nama') has-error @enderror">

        <label for="nama">
            Nama Mitra <span>*</span>
        </label>

        <input
            type="text"
            id="nama"
            name="nama"
            value="{{ old('nama', $mitra->nama ?? '') }}"
            placeholder="Contoh: Huawei"
            autocomplete="organization"
            required
        >

        @error('nama')
            <p class="admin-mitra-field-error">{{ $message }}</p>
        @enderror

    </div>


    {{-- LOGO MITRA --}}
    <div class="admin-mitra-form-field admin-mitra-image-field @error('image') has-error @enderror">

        <label for="image">
            Logo Mitra
            <span class="admin-mitra-optional">(Opsional)</span>
        </label>

        <div class="admin-mitra-upload-area">

            {{-- IMAGE PREVIEW --}}
            <div class="admin-mitra-upload-preview">

                <img
                    src="{{ !empty($mitra?->image) ? asset('storage/' . $mitra->image) : '' }}"
                    alt="Preview logo mitra"
                    data-mitra-image-preview
                    @if (empty($mitra?->image)) hidden @endif
                >

                <div
                    class="admin-mitra-upload-placeholder"
                    data-mitra-image-placeholder
                    @if (!empty($mitra?->image)) hidden @endif
                >
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.6"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="m21 15-5-5L5 21"/>
                    </svg>

                    <span>Preview Logo</span>
                </div>

            </div>


            {{-- FILE INPUT --}}
            <div class="admin-mitra-upload-control">

                <label for="image" class="admin-mitra-upload-button">
                    <svg viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 16V4"/>
                        <path d="m7 9 5-5 5 5"/>
                        <path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>
                    </svg>

                    <span>Pilih Logo</span>
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                    data-mitra-image-input
                >

                <small data-mitra-file-name>
                    Belum ada file dipilih
                </small>

                <p>
                    Format gambar yang didukung mengikuti validasi server.
                </p>

            </div>

        </div>

        @error('image')
            <p class="admin-mitra-field-error">{{ $message }}</p>
        @enderror

    </div>

</div>


{{-- FORM ACTIONS --}}
<div class="admin-mitra-form-footer">

    <a
        href="{{ route('admin.mitra.index') }}"
        class="admin-mitra-cancel"
    >
        Batal
    </a>

    <button
        type="submit"
        class="admin-mitra-submit"
    >
        <span>{{ !empty($mitra?->exists) ? 'Simpan Perubahan' : 'Simpan Mitra' }}</span>
        <span aria-hidden="true">→</span>
    </button>

</div>
