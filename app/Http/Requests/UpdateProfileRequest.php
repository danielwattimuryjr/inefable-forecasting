<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->hasUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = auth()->user();

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
            'jabatan' => [
                'required',
                'max:50'
            ],
        ];
    }
}
