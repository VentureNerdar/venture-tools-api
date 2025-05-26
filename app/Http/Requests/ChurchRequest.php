<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChurchRequest extends FormRequest
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
            'name' => 'required|string|max:300',
            'community_id' => 'required|integer|exists:communities,id',
            'description' => 'nullable|string',
            'location_longitude' => 'nullable|numeric|min:-180|max:180',
            'location_latitude' => 'nullable|numeric|min:-90|max:90',
            'google_location_data' => 'nullable|json',
            'founded_at' => 'nullable|date',
            'phone_number' => 'nullable|string|max:300',
            'website' => 'nullable|string|max:300',
            'denomination_id' => 'nullable|integer|exists:denominations,id',
            'is_visited' => 'boolean',
            'church_members_count' => 'nullable|integer',
            'confession_of_faith_count' => 'nullable|integer',
            'baptism_count' => 'nullable|integer',
            'parent_church_id' => 'nullable|integer|exists:churches,id',
            'current_prayers' => 'nullable|string',
            // 'is_active' => 'required|boolean',
        ];
    }
}
