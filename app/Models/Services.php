<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'judul',
        'deskripsi',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'judul' => 'string',
            'deskripsi' => 'string',
            'image' => 'string',
        ];
    }
}
