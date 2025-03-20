<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // todo : student ids need to be an array
            'id' => 'required|integer|exists:tenant.students,id'
        ];
    }
}
