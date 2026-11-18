<?php

namespace App\Repositories;

use App\Models\Mitra;

class MitraRepository
{
    public function all(): array
    {
        $imageurl = asset('images/products/product-placeholder.svg');

        return Mitra::query()->latest('id')->get()->map(
            static fn (Mitra $mitra): array => [
                'id' => $mitra->id,
                'name' => $mitra->nama,
                'image' => $mitra->image
                    ? (str_starts_with($mitra->image, 'mitra/')
                        ? asset('storage/' . $mitra->image)
                        : asset($mitra->image))
                    : $imageurl,
            ],
        )->all();
    }
}
