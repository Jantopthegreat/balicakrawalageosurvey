<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminProductsController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', [
            'products' => Product::latest()->paginate(5)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['images', 'remove_images']);
        $data['slug'] = $this->uniqueSlug($data['name']);

        $paths = $this->storeImages($request);
        if ($paths) {
            $data['images'] = $paths;
            $data['image']  = $paths[0];
        }

        $product = Product::create($data);

        return redirect()
            ->route('admin.products.index', $product)
            ->with('status', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $this->categories(),
        ]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->safe()->except(['images', 'remove_images']);
        $data['slug'] = $product->slug;

        $current = $this->currentImages($product);
        $toRemove = array_intersect($current, $request->input('remove_images', []));

        $kept = array_values(array_diff($current, $toRemove));
        $all  = array_values([...$kept, ...$this->storeImages($request)]);

        $this->deleteFiles($toRemove);

        $data['images'] = $all;
        $data['image']  = $all[0] ?? null;

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteProductImages($product);

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Produk berhasil dihapus.');
    }

    private function uniqueSlug(string $name): string
    {
        $slug = Str::slug($name);
        $baseSlug = $slug;
        $counter = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    private function categories(): array
    {
        return Product::query()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category')
            ->all();
    }

    private function deleteProductImages(Product $product): void
    {
        $paths = array_unique(array_filter([
            $product->image,
            ...($product->images ?? []),
        ]));

        Storage::disk('public')->delete($paths);
    }

private function storeImages(ProductRequest $request): array
{
    return collect($request->file('images', []))
        ->map(fn ($image): string => $image->store('products', 'public'))
        ->all();
}

private function currentImages(Product $product): array
{
    return array_values(array_unique(array_filter(
        $product->images ?: ($product->image ? [$product->image] : [])
    )));
}

private function deleteFiles(array $paths): void
{
    $paths = array_filter($paths, fn ($p) => str_starts_with($p, 'products/'));

    Storage::disk('public')->delete($paths);
}
}