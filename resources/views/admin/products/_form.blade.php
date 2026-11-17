@if ($errors->any())
    <div class="admin-contact-errors" role="alert">
        <div class="admin-contact-error-icon">!</div>
        <div><strong>Produk belum bisa disimpan</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    </div>
@endif

<div class="admin-contact-form-grid">
    <div class="admin-contact-form-field @error('name') has-error @enderror">
        <label for="name">Nama Produk <span>*</span></label>
        <input id="name" name="name" type="text" value="{{ old('name', $product->name ?? '') }}" placeholder="Masukkan nama produk" required>
        @error('name') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-contact-form-field @error('category') has-error @enderror">
        <label for="category">Kategori <span>*</span></label>
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
        @error('category') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-contact-form-field @error('type') has-error @enderror">
        <label for="type">Jenis Transaksi <span>*</span></label>
        <select id="type" name="type" required>
            <option value="rent" @selected(old('type', $product->type ?? '') === 'rent')>Sewa</option>
            <option value="sale" @selected(old('type', $product->type ?? '') === 'sale')>Jual</option>
        </select>
        @error('type') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-contact-form-field @error('availability') has-error @enderror">
        <label for="availability">Ketersediaan <span>*</span></label>
        @php
            $selectedAvailability = old('availability', $product->availability ?? 'Tersedia');
        @endphp
        <select id="availability" name="availability" required>
            <option value="Tersedia" @selected($selectedAvailability === 'Tersedia')>Tersedia</option>
            <option value="Tidak Tersedia" @selected($selectedAvailability === 'Tidak Tersedia')>Tidak Tersedia</option>
        </select>
        @error('availability') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-contact-form-field @error('price_label') has-error @enderror">
        <label for="price_label">Label Harga <span>*</span></label>
        <input id="price_label" name="price_label" type="text" value="{{ old('price_label', $product->price_label ?? 'Harga') }}" placeholder="Contoh: Hubungi Kami" required>
        @error('price_label') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
    <div class="admin-contact-form-field @error('description') has-error @enderror">
        <label for="description">Deskripsi <span>*</span></label>
        <textarea id="description" name="description" rows="3" placeholder="Jelaskan produk" required>{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>

    {{-- GAMBAR PRODUK --}}
    <div class="admin-contact-form-field product-field-wide @error('images') has-error @enderror @error('images.*') has-error @enderror">
        <label for="images">Gambar Produk <small>(opsional, maksimal 10 gambar, masing-masing 2 MB)</small></label>

        <div class="product-upload-area">
            <div class="product-upload-control">
                <label for="images" class="product-upload-button">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 16V4"/><path d="m7 9 5-5 5 5"/><path d="M4 16v3a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-3"/>
                    </svg>
                    <span>Pilih Gambar</span>
                </label>

                <input id="images" name="images[]" type="file" class="product-upload-input"
                    accept="image/jpeg,image/png,image/webp" multiple
                    data-existing="{{ isset($product) ? count($product->images ?: ($product->image ? [$product->image] : [])) : 0 }}">

                <small data-images-status>Belum ada file dipilih</small>
                <p>JPG, PNG, atau WEBP. Maksimal 10 gambar, 2 MB per gambar. Bisa pilih beberapa sekaligus atau menambah bertahap.</p>
            </div>

            <div class="product-upload-placeholder" data-images-placeholder>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>
                </svg>
                <span>Preview Gambar</span>
            </div>

            <div id="new-image-preview" class="product-image-grid" hidden></div>
        </div>

        @if (isset($product))
            @php
                $productImages = $product->images ?: ($product->image ? [$product->image] : []);
            @endphp
            @if ($productImages)
                <div class="product-image-manager" id="existing-images">
                    <div class="product-image-toolbar">
                        <span class="product-image-hint">Gambar saat ini. Gambar pertama menjadi gambar utama.</span>
                        <div class="product-image-actions" hidden>
                            <span class="product-image-count"></span>
                            <button type="button" class="product-image-delete" id="delete-selected">Hapus terpilih</button>
                        </div>
                    </div>

                    <div class="product-image-grid">
                        @foreach ($productImages as $productImage)
                            <div class="product-image-card" data-path="{{ $productImage }}">
                                <label class="product-image-select" title="Pilih gambar">
                                    <input type="checkbox" class="product-image-check">
                                    <span class="product-image-box" aria-hidden="true"></span>
                                </label>
                                <img src="{{ str_starts_with($productImage, 'products/') ? asset('storage/' . $productImage) : asset($productImage) }}"
                                    alt="Gambar {{ $product->name }}">
                                <span class="product-image-badge" hidden>Akan dihapus</span>
                                <button type="button" class="product-image-undo" hidden>Batalkan</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        @error('images') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
        @error('images.*') <p class="admin-contact-field-error">{{ $message }}</p> @enderror
    </div>
</div>

<div class="admin-contact-form-footer">
    <a href="{{ route('admin.products.index') }}" class="admin-contact-cancel">Batal</a>
    <button class="admin-contact-submit" type="submit"><span>Simpan Produk</span><span aria-hidden="true">→</span></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    /* ---------- Kategori ---------- */
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

    /* ---------- Gambar lama (pilih & hapus) ---------- */
    const manager = document.querySelector('#existing-images');
    if (manager) {
        const actions = manager.querySelector('.product-image-actions');
        const count = manager.querySelector('.product-image-count');
        const deleteBtn = manager.querySelector('#delete-selected');
        const cards = Array.from(manager.querySelectorAll('.product-image-card'));

        const updateBar = () => {
            const selected = manager.querySelectorAll('.product-image-check:checked').length;
            actions.hidden = selected === 0;
            count.textContent = `${selected} gambar dipilih`;
        };

        cards.forEach((card) => {
            const check = card.querySelector('.product-image-check');
            const badge = card.querySelector('.product-image-badge');
            const undo = card.querySelector('.product-image-undo');

            check.addEventListener('change', () => {
                card.classList.toggle('is-selected', check.checked);
                updateBar();
            });

            undo.addEventListener('click', () => {
                card.querySelector('input[name="remove_images[]"]')?.remove();
                card.classList.remove('is-removed');
                badge.hidden = true;
                undo.hidden = true;
                check.disabled = false;
            });
        });

        deleteBtn.addEventListener('click', () => {
            manager.querySelectorAll('.product-image-card.is-selected').forEach((card) => {
                const check = card.querySelector('.product-image-check');

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'remove_images[]';
                hidden.value = card.dataset.path;
                card.appendChild(hidden);

                check.checked = false;
                check.disabled = true;
                card.classList.remove('is-selected');
                card.classList.add('is-removed');
                card.querySelector('.product-image-badge').hidden = false;
                card.querySelector('.product-image-undo').hidden = false;
            });
            updateBar();
        });
    }

    /* ---------- Gambar baru (upload bertahap) ---------- */
    const imageInput = document.querySelector('#images');
    const previewBox = document.querySelector('#new-image-preview');
    const status = document.querySelector('[data-images-status]');
    const placeholder = document.querySelector('[data-images-placeholder]');
    if (!imageInput || !previewBox || !status || !placeholder) return;

    const MAX_FILES = 10;
    const MAX_SIZE = 2 * 1024 * 1024;
    const allowed = ['image/jpeg', 'image/png', 'image/webp'];
    const dt = new DataTransfer();

    const existingCount = () => {
        const base = Number(imageInput.dataset.existing || 0);
        const removed = document.querySelectorAll('input[name="remove_images[]"]').length;
        return base - removed;
    };

    const sync = () => {
        imageInput.files = dt.files;
        previewBox.innerHTML = '';

        const total = dt.files.length;
        status.textContent = total ? `${total} gambar baru dipilih` : 'Belum ada file dipilih';
        placeholder.hidden = total > 0;
        previewBox.hidden = total === 0;

        Array.from(dt.files).forEach((file, index) => {
            const card = document.createElement('div');
            card.className = 'product-image-card is-new';

            const img = document.createElement('img');
            img.alt = file.name;
            img.src = URL.createObjectURL(file);
            img.onload = () => URL.revokeObjectURL(img.src);

            const badge = document.createElement('span');
            badge.className = 'product-image-new-badge';
            badge.textContent = 'Baru';

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'product-image-remove';
            remove.setAttribute('aria-label', `Hapus ${file.name}`);
            remove.textContent = '×';
            remove.addEventListener('click', () => {
                const remaining = Array.from(dt.files).filter((_, i) => i !== index);
                dt.items.clear();
                remaining.forEach((f) => dt.items.add(f));
                sync();
            });

            card.append(img, badge, remove);
            previewBox.appendChild(card);
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