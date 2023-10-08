<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class DueDateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'due_date'          => 'nullable|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'due_date.after_or_equal' => 'The due date must be equal or greater than the current date.',
        ];
    }
}
