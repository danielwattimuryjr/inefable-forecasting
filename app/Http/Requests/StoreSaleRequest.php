<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSaleRequest extends FormRequest
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
        $products = Product::get(['id'])->pluck('id');

        return [
            'product_id' => [
                'required',
                Rule::in($products)
            ],
            'periode_penjualan' => [
                'required',
                'date',
                Rule::unique('sales')
            ],
            'jumlah_penjualan' => [
                'required',
                'decimal'
            ]
        ];
    }
}
