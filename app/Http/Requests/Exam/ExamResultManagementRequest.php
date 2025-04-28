<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamResultManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'integer', 'exists:tenant.exams,id'],
            'result_id' => ['nullable', 'integer', 'exists:tenant.exam_results,id'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }


    public function prepareForValidation(): void
    {
        if ($this->route('id')) {
            $this->merge(['exam_id' => $this->route('id')]);
        }
        if ($this->route('result_id')) {
            $this->merge(['result_id' => $this->route('result_id')]);
        }

        // Set default values if not provided
        $this->merge([
            'per_page' => $this->per_page ?? 15,
            'page' => $this->page ?? 1,
        ]);
    }
}