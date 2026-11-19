@if ($errors->any())
    <div class="admin-contact-errors" role="alert">
        <div class="admin-contact-error-icon">!</div>
        <div><strong>Layanan belum bisa disimpan</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    </div>
@endif

@php
    $currentImage = isset($service) && $service->image
        ? (str_starts_with($service->image, 'services/') ? asset('storage/' . $service->image) : asset($service->image))
        : '';
@endphp

<div class="admin-contact-form-grid">
    <div class="admin-contact-form-field @error('judul') has-error @enderror">
        <label for="judul">Judul Layanan <span>*</span></label>
        <input id="judul" name="judul" type="text" value="{{ old('judul', $service->judul ?? '') }}" placeholder="Masukkan judul layanan" required>
        @error('judul') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-contact-form-field @error('deskripsi') has-error @enderror">
        <label for="deskripsi">Deskripsi <span>*</span></label>
        <textarea id="deskripsi" name="deskripsi" rows="3" placeholder="Jelaskan layanan yang tersedia" required>{{ old('deskripsi', $service->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>

    {{-- GAMBAR LAYANAN --}}
    <div class="admin-contact-form-field product-field-wide @error('image') has-error @enderror">
        <label for="image">Gambar Layanan <small>(opsional, maksimal 8 MB)</small></label>

        <div class="product-upload-area">
            <div class="product-upload-control">
                <label for="image" class="product-upload-button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 16V4"/><path d="m7 9 5-5 5 5"/><path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>
                    </svg>
                    <span data-image-button-text>{{ $currentImage ? 'Ganti Gambar' : 'Pilih Gambar' }}</span>
                </label>

                <input id="image" name="image" type="file" class="product-upload-input"
                    accept="image/jpeg,image/png,image/webp">

                <small data-image-status>{{ $currentImage ? 'Menggunakan gambar saat ini' : 'Belum ada file dipilih' }}</small>
                <p>JPG, PNG, atau WEBP. Maksimal 8 MB.</p>
            </div>

            <div class="service-upload-preview" data-image-preview-box>
                <img src="{{ $currentImage }}" alt="Preview gambar layanan" data-image-preview @if (!$currentImage) hidden @endif>

                <div class="product-upload-placeholder service-upload-placeholder" data-image-placeholder @if ($currentImage) hidden @endif>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>
                    </svg>
                    <span>Preview Gambar</span>
                </div>

                <span class="product-image-new-badge" data-image-new-badge hidden>Baru</span>
                <button type="button" class="product-image-remove" data-image-clear hidden aria-label="Batalkan gambar baru">×</button>
            </div>
        </div>

        @error('image') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="admin-contact-form-footer">
    <a href="{{ route('admin.services.index') }}" class="admin-contact-cancel">Batal</a>
    <button class="admin-contact-submit" type="submit"><span>Simpan Layanan</span><span aria-hidden="true">→</span></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.querySelector('#image');
    const preview = document.querySelector('[data-image-preview]');
    const placeholder = document.querySelector('[data-image-placeholder]');
    const status = document.querySelector('[data-image-status]');
    const buttonText = document.querySelector('[data-image-button-text]');
    const badge = document.querySelector('[data-image-new-badge]');
    const clearBtn = document.querySelector('[data-image-clear]');
    if (!input || !preview || !placeholder || !status || !buttonText || !badge || !clearBtn) return;

    const MAX_SIZE = 8 * 1024 * 1024;
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    const originalSrc = preview.getAttribute('src') || '';
    let objectUrl = null;

    const release = () => {
        if (objectUrl) { URL.revokeObjectURL(objectUrl); objectUrl = null; }
    };

    const showOriginal = () => {
        release();
        input.value = '';
        badge.hidden = true;
        clearBtn.hidden = true;

        if (originalSrc) {
            preview.src = originalSrc;
            preview.hidden = false;
            placeholder.hidden = true;
            status.textContent = 'Menggunakan gambar saat ini';
            buttonText.textContent = 'Ganti Gambar';
        } else {
            preview.removeAttribute('src');
            preview.hidden = true;
            placeholder.hidden = false;
            status.textContent = 'Belum ada file dipilih';
            buttonText.textContent = 'Pilih Gambar';
        }
    };

    input.addEventListener('change', () => {
        const file = input.files[0];
        if (!file) { showOriginal(); return; }

        if (!allowed.includes(file.type)) {
            alert('Format gambar harus JPG, PNG, atau WEBP.');
            showOriginal();
            return;
        }
        if (file.size > MAX_SIZE) {
            alert('Ukuran gambar maksimal 8 MB.');
            showOriginal();
            return;
        }

        release();
        objectUrl = URL.createObjectURL(file);
        preview.src = objectUrl;
        preview.hidden = false;
        placeholder.hidden = true;
        badge.hidden = false;
        clearBtn.hidden = false;
        status.textContent = file.name;
        buttonText.textContent = 'Ganti Gambar';
    });

    clearBtn.addEventListener('click', showOriginal);
});
</script>