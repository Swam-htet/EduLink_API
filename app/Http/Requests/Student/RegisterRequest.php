<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:students',
            'password' => 'required|min:12|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,16}$/',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20|regex:/^09\d{9}$/',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string|max:500',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20|regex:/^09\d{9}$/',
            'parent_email' => 'nullable|email|max:255',
            'parent_occupation' => 'nullable|string|max:255',
            'parent_address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20|regex:/^09\d{9}$/',
            'enrollment_date' => 'required|date|after:date_of_birth',
            'blood_group' => 'nullable|enum:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'achievements' => 'nullable|array',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'bio' => 'nullable|string|max:500',
            'nationality' => 'required|string|max:255',
            'religion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email address is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 12 characters',
            'password.max' => 'Password cannot exceed 16 characters',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character',
            'first_name.required' => 'First name is required',
            'first_name.string' => 'First name must be text',
            'first_name.max' => 'First name cannot exceed 255 characters',
            'last_name.required' => 'Last name is required',
            'last_name.string' => 'Last name must be text',
            'last_name.max' => 'Last name cannot exceed 255 characters',
            'phone_number.string' => 'Phone number must be text',
            'phone_number.max' => 'Phone number cannot exceed 20 characters',
            'phone_number.regex' => 'Phone number must start with 09 followed by 9 digits',
            'date_of_birth.required' => 'Date of birth is required',
            'date_of_birth.date' => 'Date of birth must be a valid date',
            'date_of_birth.before' => 'Date of birth must be in the past',
            'gender.required' => 'Gender is required',
            'gender.in' => 'Gender must be male, female, or other',
            'address.required' => 'Address is required',
            'address.string' => 'Address must be text',
            'address.max' => 'Address cannot exceed 500 characters',
            'parent_name.required' => 'Parent name is required',
            'parent_name.string' => 'Parent name must be text',
            'parent_name.max' => 'Parent name cannot exceed 255 characters',
            'parent_phone.required' => 'Parent phone number is required',
            'parent_phone.string' => 'Parent phone number must be text',
            'parent_phone.max' => 'Parent phone number cannot exceed 20 characters',
            'parent_phone.regex' => 'Parent phone number must start with 09 followed by 9 digits',
            'parent_email.email' => 'Parent email must be a valid email address',
            'parent_email.max' => 'Parent email cannot exceed 255 characters',
            'parent_occupation.string' => 'Parent occupation must be text',
            'parent_occupation.max' => 'Parent occupation cannot exceed 255 characters',
            'parent_address.string' => 'Parent address must be text',
            'parent_address.max' => 'Parent address cannot exceed 500 characters',
            'emergency_contact_name.required' => 'Emergency contact name is required',
            'emergency_contact_name.string' => 'Emergency contact name must be text',
            'emergency_contact_name.max' => 'Emergency contact name cannot exceed 255 characters',
            'emergency_contact_phone.required' => 'Emergency contact phone is required',
            'emergency_contact_phone.string' => 'Emergency contact phone must be text',
            'emergency_contact_phone.max' => 'Emergency contact phone cannot exceed 20 characters',
            'emergency_contact_phone.regex' => 'Emergency contact phone must start with 09 followed by 9 digits',
            'enrollment_date.required' => 'Enrollment date is required',
            'enrollment_date.date' => 'Enrollment date must be a valid date',
            'enrollment_date.after' => 'Enrollment date must be after date of birth',
            'blood_group.enum' => 'Blood group must be one of: A+, A-, B+, B-, AB+, AB-, O+, O-',
            'achievements.array' => 'Achievements must be provided as a list',
            'profile_photo.image' => 'Profile photo must be an image',
            'profile_photo.mimes' => 'Profile photo must be in one of these formats: jpeg, png, jpg, gif, svg',
            'profile_photo.max' => 'Profile photo must be less than 2MB',
            'bio.string' => 'Bio must be text',
            'bio.max' => 'Bio cannot exceed 500 characters',
            'nationality.required' => 'Nationality is required',
            'nationality.string' => 'Nationality must be text',
            'nationality.max' => 'Nationality cannot exceed 255 characters',
            'religion.string' => 'Religion must be text',
            'religion.max' => 'Religion cannot exceed 255 characters',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors()
        ], 422));
    }
}
