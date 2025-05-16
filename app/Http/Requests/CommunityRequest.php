<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommunityRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'location_longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'location_latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'google_location_data' => ['nullable', 'json'],
            'conducted_survey_of_community_needs' => ['nullable', 'boolean'],
            'community_needs_1' => ['nullable', 'string'],
            'community_needs_2' => ['nullable', 'string'],
            'community_needs_3' => ['nullable', 'string'],
            'community_needs_4' => ['nullable', 'string'],
            'community_needs_5' => ['nullable', 'string'],
            'created_by' => ['required', 'integer'],
            'peace_persons' => ['nullable', 'array'],
            'committees' => ['nullable', 'array'],
            'checklists' => ['nullable', 'array'],
        ];
    }
}
