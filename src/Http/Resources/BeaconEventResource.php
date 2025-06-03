<?php

namespace Outerweb\Beacon\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BeaconEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'type' => $this->type,
            'label' => $this->label,
            'properties' => $this->properties,
            'custom_properties' => $this->custom_properties,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
