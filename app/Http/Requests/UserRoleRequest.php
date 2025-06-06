<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRoleRequest extends FormRequest
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
            // 'name' => 'required|string|max:255|unique:user_roles,name,',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('user_roles', 'name')->ignore($this->route('id'))
            ],
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }
}
