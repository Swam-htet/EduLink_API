<?php

namespace App\Http\Requests\TenantConfig;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class StoreTenantConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => 'required|string|max:255',
            'value' => 'required',
            'type' => 'required|string|in:string,boolean,integer,json',
            'group' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_system' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'key.required' => 'The key field is required.',
        ];
    }

    // failed validation
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
