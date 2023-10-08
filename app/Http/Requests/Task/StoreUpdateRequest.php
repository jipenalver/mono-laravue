<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'user_id'   => request()->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title'             => 'required|string',
            'description'       => 'required|string',
            'due_date'          => 'nullable|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'priority'          => 'nullable|string',
            'user_id'           => 'integer|exists:App\Models\User,id',
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
