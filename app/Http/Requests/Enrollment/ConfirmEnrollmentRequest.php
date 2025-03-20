<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmEnrollmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'token' => 'required|string|max:64',
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => 'Enrollment token is required.',
            'token.string' => 'Invalid token format.',
        ];
    }
}