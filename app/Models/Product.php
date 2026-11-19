<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'category',
        'type',
        'description',
        'image',
        'images',
        'availability',
        'price_label',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }
}
