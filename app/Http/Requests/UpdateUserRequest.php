<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $user = $this->route('user');

        return [
            'username' => [
                'required',
                Rule::unique('users')->ignore($user),
                'max:50'
            ],
            'nama' => [
                'required',
                'max:50'
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user)
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
                'sometimes',

            ]
        ];
    }
}
