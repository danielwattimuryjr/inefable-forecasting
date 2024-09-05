<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productCategory = $this->route('productCategory');

        return [
            'nama_kategori' => [
                'required',
                'min:5',
                'max:50',
                Rule::unique('product_categories')->ignore($productCategory),
            ]
        ];
    }
}
