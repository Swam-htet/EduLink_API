<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StaffAccCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can add authorization logic here if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenant.staff,email',
            'phone' => 'required|string|max:20',
            'role' => 'required|string|in:admin,teacher,staff',
            'nrc' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date',
            'address' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'The first name field is required',
            'first_name.max' => 'The first name must not exceed 255 characters',
            'last_name.required' => 'The last name field is required',
            'last_name.max' => 'The last name must not exceed 255 characters',
            'email.required' => 'The email field is required',
            'email.email' => 'Please provide a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'The phone number is required',
            'phone.max' => 'The phone number must not exceed 20 characters',
            'role.required' => 'The role field is required',
            'role.in' => 'Invalid role selected. Must be admin, teacher, or staff',
        ];
    }

    // /**
    //  * Handle a failed validation attempt.
    //  *
    //  * @param Validator $validator
    //  * @return void
    //  * @throws HttpResponseException
    //  */
    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'message' => 'Validation failed',
    //         'errors' => $validator->errors()
    //     ], Response::HTTP_UNPROCESSABLE_ENTITY));
    // }
}
