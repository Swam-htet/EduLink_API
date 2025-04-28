<?php

namespace App\Http\Requests\ClassSchedule;

use Illuminate\Foundation\Http\FormRequest;

class ListClassScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_id' => ['sometimes', 'integer', 'exists:tenant.classes,id'],
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'class_id' => $this->route('class_id')
        ]);
    }
}
