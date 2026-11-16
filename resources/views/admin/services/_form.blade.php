@if ($errors->any())
    <div class="admin-contact-errors" role="alert">
        <div class="admin-contact-error-icon">!</div>
        <div><strong>Layanan belum bisa disimpan</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    </div>
@endif

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
    <div class="admin-contact-form-field @error('image') has-error @enderror">
        <label for="image">Gambar Layanan <small>(opsional, maksimal 8 MB)</small></label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
        @if (isset($service) && $service->image)
            <img class="admin-image-preview is-visible" src="{{ str_starts_with($service->image, 'services/') ? asset('storage/' . $service->image) : asset($service->image) }}" alt="Gambar {{ $service->judul }}">
        @endif
        @error('image') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="admin-contact-form-footer">
    <a href="{{ route('admin.services.index') }}" class="admin-contact-cancel">Batal</a>
    <button class="admin-contact-submit" type="submit"><span>Simpan Layanan</span><span aria-hidden="true">→</span></button>
</div>
