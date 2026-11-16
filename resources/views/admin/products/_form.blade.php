@if ($errors->any())
    <div class="admin-alert" role="alert">
        <strong>Produk belum bisa disimpan</strong>
        <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<div class="admin-editor-grid">
    <div class="admin-editor-field @error('name') has-error @enderror">
        <label for="name">Nama produk</label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" required>
        @error('name') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field @error('category') has-error @enderror">
        <label for="category">Kategori</label>
        @php
            $selectedCategory = old('category', $product->category ?? '');
            $isNewCategory = $selectedCategory !== '' && !in_array($selectedCategory, $categories ?? [], true);
        @endphp
        <select id="category" name="category" required>
            <option value="" disabled @selected($selectedCategory === '')>Pilih kategori</option>
            @foreach ($categories ?? [] as $category)
                <option value="{{ $category }}" @selected($selectedCategory === $category)>{{ $category }}</option>
            @endforeach
            <option value="__new__" @selected($isNewCategory)>+ Tambah kategori baru</option>
        </select>
        <input
            id="category-new"
            name="category_new"
            type="text"
            value="{{ $isNewCategory ? $selectedCategory : old('category_new') }}"
            placeholder="Masukkan kategori baru"
            @if(!$isNewCategory) hidden @endif
            @disabled(!$isNewCategory)
            @required($isNewCategory)
        >
        <small>Pilih kategori yang tersedia atau tambah kategori baru.</small>
        @error('category') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field @error('type') has-error @enderror">
        <label for="type">Jenis transaksi</label>
        <select id="type" name="type" required>
            <option value="rent" @selected(old('type', $product->type ?? '') === 'rent')>Sewa</option>
            <option value="sale" @selected(old('type', $product->type ?? '') === 'sale')>Jual</option>
        </select>
        @error('type') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field @error('availability') has-error @enderror">
    <label for="availability">Ketersediaan</label>
    @php
        $selectedAvailability = old('availability', $product->availability ?? 'Tersedia');
    @endphp
    <select id="availability" name="availability" required>
        <option value="Tersedia" @selected($selectedAvailability === 'Tersedia')>Tersedia</option>
        <option value="Tidak Tersedia" @selected($selectedAvailability === 'Tidak Tersedia')>Tidak Tersedia</option>
    </select>
    @error('availability') <p class="admin-field-error">{{ $message }}</p> @enderror
</div>
    <div class="admin-editor-field @error('price_label') has-error @enderror">
        <label for="price_label">Label harga</label>
        <input id="price_label" name="price_label" type="text" value="{{ old('price_label', $product->price_label ?? 'Harga') }}" required>
        @error('price_label') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field admin-editor-field-wide @error('description') has-error @enderror">
        <label for="description">Deskripsi</label>
        <textarea id="description" name="description" rows="6" required>{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="admin-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-editor-field admin-editor-field-wide @error('images') has-error @enderror @error('images.*') has-error @enderror">
    <label for="images">Gambar produk <span>(opsional, maksimal 10 gambar, masing-masing 2 MB)</span></label>
    <input id="images" name="images[]" type="file"
        accept="image/jpeg,image/png,image/webp" multiple
        data-existing="{{ isset($product) ? count($product->images ?: ($product->image ? [$product->image] : [])) : 0 }}">

    <div id="new-image-preview" class="admin-image-preview-grid"></div>

    @if (isset($product))
        @php
            $productImages = $product->images ?: ($product->image ? [$product->image] : []);
        @endphp
        @if ($productImages)
            <p><small>Gambar saat ini (centang untuk menghapus). Gambar pertama menjadi gambar utama.</small></p>
            <div class="admin-image-preview-grid">
                @foreach ($productImages as $productImage)
                    <label class="admin-image-item">
                        <img class="admin-image-preview is-visible"
                             src="{{ str_starts_with($productImage, 'products/') ? asset('storage/' . $productImage) : asset($productImage) }}"
                             alt="Gambar {{ $product->name }}">
                        <span><input type="checkbox" name="remove_images[]" value="{{ $productImage }}"> Hapus</span>
                    </label>
                @endforeach
            </div>
        @endif
    @endif

    @error('images') <p class="admin-field-error">{{ $message }}</p> @enderror
    @error('images.*') <p class="admin-field-error">{{ $message }}</p> @enderror
</div>
</div>

<div class="admin-editor-actions">
    <a class="admin-back-link" href="{{ route('admin.products.index') }}">Batal</a>
    <button class="admin-button" type="submit">Simpan produk</button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const category = document.querySelector('#category');
    const newCategory = document.querySelector('#category-new');

    if (category && newCategory) {
        const toggleNewCategory = (focus = false) => {
            const isNew = category.value === '__new__';
            newCategory.hidden = !isNew;
            newCategory.disabled = !isNew;
            newCategory.required = isNew;
            if (isNew && focus) newCategory.focus();
        };

        category.addEventListener('change', () => toggleNewCategory(true));
        toggleNewCategory();
    }

    const imageInput = document.querySelector('#images');
    const previewBox = document.querySelector('#new-image-preview');
    if (!imageInput || !previewBox) return;

    const MAX_FILES = 10;
    const MAX_SIZE = 2 * 1024 * 1024;
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    const dt = new DataTransfer();

    const existingCount = () => {
        const base = Number(imageInput.dataset.existing || 0);
        const removed = document.querySelectorAll('input[name="remove_images[]"]:checked').length;
        return base - removed;
    };

    const sync = () => {
        imageInput.files = dt.files;
        previewBox.innerHTML = '';

        Array.from(dt.files).forEach((file, index) => {
            const item = document.createElement('div');
            item.className = 'admin-image-item';

            const img = document.createElement('img');
            img.className = 'admin-image-preview is-visible';
            img.alt = file.name;
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = 'Hapus';
            btn.addEventListener('click', () => {
                const remaining = Array.from(dt.files).filter((_, i) => i !== index);
                dt.items.clear();
                remaining.forEach((f) => dt.items.add(f));
                sync();
            });

            item.append(img, btn);
            previewBox.appendChild(item);
        });
    };

    imageInput.addEventListener('change', () => {
        const errors = [];
        const picked = Array.from(imageInput.files);

        picked.forEach((file) => {
            const duplicate = Array.from(dt.files).some(
                (f) => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified
            );

            if (duplicate) return;
            if (!allowed.includes(file.type)) { errors.push(`${file.name}: format harus JPG, PNG, atau WEBP.`); return; }
            if (file.size > MAX_SIZE) { errors.push(`${file.name}: lebih dari 2 MB.`); return; }
            if (existingCount() + dt.files.length >= MAX_FILES) { errors.push(`Maksimal ${MAX_FILES} gambar.`); return; }

            dt.items.add(file);
        });

        sync();
        if (errors.length) alert([...new Set(errors)].join('\n'));
    });
});
</script>