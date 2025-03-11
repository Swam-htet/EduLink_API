<?php

namespace App\Http\Requests\TenantConfig;

use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateTenantConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'configs' => 'required|array',
            'configs.*.key' => 'required|string|exists:tenant_configs,key',
            'configs.*.value' => 'required',
        ];
    }
}
