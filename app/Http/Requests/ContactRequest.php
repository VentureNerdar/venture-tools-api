<?php

namespace App\Http\Requests;

use App\Enums\Gender;
use App\Enums\AgeGroup;
use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'nickname' => 'nullable|string|max:255',
            'gender' => ['required', 'in:male,female'],
            'age' => ['required', 'in:' . implode(',', AgeGroup::values())],
            'baptism_date' => ['nullable', 'date'],
            'baptized_by' => 'nullable|exists:contacts,id',
            'current_prayers' => 'nullable|string',
            // 'contact_status_id' => 'required|exists:statuses,id',
            'faith_status_id' => 'required|exists:statuses,id',
            'assigned_to' => 'nullable|exists:users,id',
            'coached_by' => 'nullable|exists:contacts,id',
            'people_group' => 'nullable|array',
            'contact_communication_platforms' => 'nullable|array',
            'faith_milestones' => 'nullable|array',
            'is_active' => 'required|boolean',



            // 'denomination_id' => 'required|exists:denominations,id',
            // 'faith_milestone_id' => 'required|exists:faith_milestones,id',
            // 'communication_platforms' => 'required|array',
            // 'communication_platforms.*.id' => 'required|exists:communication_platforms,id',
            // 'communication_platforms.*.value' => 'required|string|max:255',
        ];
    }
}
