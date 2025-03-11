<?php

namespace App\Http\Requests\TenantConfig;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTenantConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value' => 'required',
            'type' => 'sometimes|string|in:string,boolean,integer,json',
            'group' => 'sometimes|nullable|string|max:255',
            'description' => 'sometimes|nullable|string',
            'is_system' => 'sometimes|boolean',
        ];
    }
}
