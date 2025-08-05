<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class iShareAPISettingRequest extends FormRequest
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
            'setting_name' => [
                'required',
                'string',
                'max:255',
                Rule::in([
                    'iShareAPIUserName',
                    'iShareAPISecret',
                    'iShareAPIURL',
                ])
            ],
            'setting_value' => 'required|string|max:255',
        ];
    }
}
