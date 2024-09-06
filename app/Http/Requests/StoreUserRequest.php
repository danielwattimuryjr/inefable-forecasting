<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        return [
            'username' => [
                'required',
                Rule::unique('users'),
                'max:50'
            ],
            'nama' => [
                'required',
                'max:50'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')
            ],
            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'user',
                    'direktur_operasional'
                ])
            ],
            'jabatan' => [
                'required',
                'max:50'
            ],
            'password' => [
                'required'
            ]
        ];
    }
}
