<?php

namespace App\Http\Requests\TaskAttachment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'attachments'            => 'nullable',
            'attachments.*'          => 'mimes:svg,png,jpg,jpeg,mp4,csv,txt,doc,docx'
        ];
    }
}
