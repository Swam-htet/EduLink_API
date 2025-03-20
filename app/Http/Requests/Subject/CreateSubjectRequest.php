<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => [
                'required',
                'integer',
                Rule::exists('tenant.courses', 'id')->whereNull('deleted_at'),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'credits' => 'required|integer|min:1',
        ];
    }
}
