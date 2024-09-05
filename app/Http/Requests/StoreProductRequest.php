<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $availableCategories = \App\Models\ProductCategory::get(['id'])->pluck('id');

        return [
            'warna' => [
                'required',
                'string',
                'min:5',
                'max:50'
            ],
            'variasi' => [
                'required',
                'string',
                'max:50'
            ],
            'nama_produk' => [
                'required',
                'string',
                'min:5',
                'max:50'
            ],
            'kode_produk' => [
                'required',
                Rule::unique('products'),
            ],
            'product_category_id' => [
                'required',
                Rule::in($availableCategories)
            ]
        ];
    }
}
