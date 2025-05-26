<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_type_id' => ['sometimes', 'exists:event_types,id'],
            'location_id' => ['sometimes', 'exists:locations,id'],
            'start_time' => ['sometimes', 'date'],
            'end_time' => ['sometimes', 'date', 'after_or_equal:start_time'],
        ];
    }
}
