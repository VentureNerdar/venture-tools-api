<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceRequest extends FormRequest
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
            'device_id' => 'required|string|max:255',
            'device_type' => 'required|string|in:web,ios,android',
            'device_name' => 'required|string|max:255',
            'notification_token' => 'nullable|string',
            'last_ip_address' => 'nullable|string|max:45'
        ];
    }
}
