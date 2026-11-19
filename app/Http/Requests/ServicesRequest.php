<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServicesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'judul' => trim((string) $this->input('judul')),
            'deskripsi' => trim((string) $this->input('deskripsi')),
        ]);
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string', 'max:5000'],
            'image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
        ];
    }

    public function attributes(): array
    {
        return [
            'judul' => 'judul',
            'deskripsi' => 'deskripsi',
            'image' => 'gambar',
        ];
    }

    public function messages(): array
    {
        return [
            'image.uploaded' => 'Gambar gagal diunggah. Pastikan ukuran file tidak melebihi 8 MB.',
            'image.file' => 'Gambar gagal diunggah. Pastikan ukuran file tidak melebihi 8 MB.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'image.max' => 'Ukuran gambar maksimal 8 MB.',
        ];
    }
}