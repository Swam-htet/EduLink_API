<?php

namespace App\Http\Resources\TenantConfig;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TenantConfigCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'configs' => $this->collection->map(function ($item) {
                return new TenantConfigResource($item);
            }),
        ];
    }
}
