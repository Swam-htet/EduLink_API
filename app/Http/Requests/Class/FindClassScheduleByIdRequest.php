<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;

class FindClassScheduleByIdRequest extends FormRequest
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
            'id' => 'required|integer|exists:tenant.class_schedules,id'
        ];
    }
}
