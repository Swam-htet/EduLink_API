<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class StudentRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:tenant.students,email',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female,other',
            'profile_photo' => 'nullable|image|max:2048', // 2MB max
            'nrc' => 'string|max:255',
            'guardian_name' => 'required|string|max:255',
            'guardian_phone' => 'required|string|max:20',
            'guardian_relationship' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'This email is already registered.',
            'password.confirmed' => 'Password confirmation does not match.',
            'profile_photo.max' => 'Profile photo must not be larger than 2MB.',
            'nrc.string' => 'NRC must be a string.',
            'guardian_name.required' => 'Guardian name is required.',
            'guardian_phone.required' => 'Guardian phone is required.',
            'guardian_relationship.required' => 'Guardian relationship is required.',
            'profile_photo.image' => 'Profile photo must be an image.',
        ];
    }
}
