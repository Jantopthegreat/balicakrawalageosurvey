@if ($errors->any())
    <div class="admin-alert" role="alert">
        <strong>Layanan belum bisa disimpan</strong>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="admin-editor-grid">
    <div class="admin-editor-field @error('judul') has-error @enderror">
        <label for="judul">Judul layanan</label>
        <input id="judul" name="judul" type="text" value="{{ old('judul', $service->judul ?? '') }}" required>
        @error('judul') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field admin-editor-field-wide @error('deskripsi') has-error @enderror">
        <label for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" rows="6" required>{{ old('deskripsi', $service->deskripsi ?? '') }}</textarea>
        @error('deskripsi') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field admin-editor-field-wide @error('image') has-error @enderror">
        <label for="image">Gambar layanan <span>(opsional, maksimal 8 MB)</span></label>
        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp">
        @if (isset($service) && $service->image)
            <img class="admin-image-preview is-visible" src="{{ str_starts_with($service->image, 'services/') ? asset('storage/' . $service->image) : asset($service->image) }}" alt="Gambar {{ $service->judul }}">
        @endif
        @error('image') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="admin-editor-actions">
    <a class="admin-back-link" href="{{ route('admin.services.index') }}">Batal</a>
    <button class="admin-button" type="submit">Simpan layanan</button>
</div>
