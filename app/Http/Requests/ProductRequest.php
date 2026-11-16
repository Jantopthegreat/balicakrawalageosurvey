<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $category = $this->input('category') === '__new__'
            ? $this->input('category_new')
            : $this->input('category');

        $this->merge([
            'category' => is_string($category) ? trim($category) : $category,
        ]);
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:255'],
            'category'       => ['required', 'string', 'max:100'],
            'type'           => ['required', 'in:rent,sale'],
            'availability'   => ['required', 'in:Tersedia,Tidak Tersedia'],
            'price_label'    => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'images'         => ['nullable', 'array', 'max:10'],
            'images.*'       => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'remove_images'   => ['nullable', 'array'],
            'remove_images.*' => ['string'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $product = $this->route('product');
            $current = $product ? ($product->images ?: ($product->image ? [$product->image] : [])) : [];
            $removed = count(array_intersect($current, $this->input('remove_images', [])));
            $new     = count($this->file('images', []));

            if (count($current) - $removed + $new > 10) {
                $validator->errors()->add('images', 'Total gambar produk maksimal 10.');
            }
        }];
    }

    public function messages(): array
    {
        return [
            'images.max'      => 'Maksimal 10 gambar.',
            'images.*.image'  => 'File harus berupa gambar.',
            'images.*.mimes'  => 'Format gambar harus JPG, PNG, atau WEBP.',
            'images.*.max'    => 'Ukuran tiap gambar maksimal 2 MB.',
            'availability.in' => 'Ketersediaan harus Tersedia atau Tidak Tersedia.',
        ];
    }
}