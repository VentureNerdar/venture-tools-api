<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SystemLanguageTranslationRequest extends FormRequest
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
            'system_language_id' => 'required|exists:system_languages,id',
            'system_language_word_id' => 'required|exists:system_language_words,id',
            'translation' => 'required|string|max:255',
        ];
    }
}
