<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function all(): array
    {
        return Product::query()->latest('id')->get()->map(
            fn (Product $product): array => [
                'slug' => $product->slug,
                'name' => $product->name,
                'category' => $product->category,
                'type' => $product->type,
                'description' => $product->description,
                'images' => $images = $this->imageUrls($product),
                'image' => $images[0],
                'availability' => $product->availability,
                'price_label' => $product->price_label,
            ],
        )->all();
    }

    public function findBySlug(string $slug): ?array
    {
        foreach ($this->all() as $product) {
            if ($product['slug'] === $slug) {
                return $product;
            }
        }

        return null;
    }

    private function imageUrls(Product $product): array
    {
        $paths = $product->images ?: ($product->image ? [$product->image] : []);

        if ($paths === []) {
            return [asset('images/products/product-placeholder.svg')];
        }

        return array_map(
            static fn (string $path): string => str_starts_with($path, 'products/')
                ? asset('storage/' . $path)
                : asset($path),
            $paths,
        );
    }
}
