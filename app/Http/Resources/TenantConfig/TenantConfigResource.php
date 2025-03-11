<?php

namespace App\Http\Resources\TenantConfig;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantConfigResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'key' => $this['key'],
            'value' => $this['type'],
            'type' => $this['type'],
            'group' => $this['group'],
            'description' => $this['description'],
            'is_system' => $this['is_system'],
        ];
    }
}
