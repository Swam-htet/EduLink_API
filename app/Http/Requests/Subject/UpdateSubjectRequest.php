<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => [
                'required',
                'integer',
                Rule::exists('tenant.subjects', 'id')->whereNull('deleted_at'),
            ],
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'credits' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|string|in:active,inactive'
        ];
    }
}
