<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->route('id')),
            ],
            // 'email' => 'required|string|email|unique:users,email',
            // 'password' => 'required|min:8|confirmed',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'password' => [
                'sometimes',
                'min:8',
                'confirmed'
            ],
            'user_role_id' => 'required|exists:user_roles,id',
            'movement_id' => 'nullable|exists:movements,id',
            'is_active' => 'required|boolean',
            'biography' => 'nullable|string',
            'last_login_at' => 'nullable|date',
            'preferred_language_id' => 'nullable|exists:system_languages,id',
            'contact_id' => 'nullable|exists:contacts,id',
        ];
    }
}
