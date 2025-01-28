<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BolusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'active' => $this->active,
            'number' => $this->number,
            'device_number' => $this->device_number,
            'batch_number' => $this->batch_number,
            'produced_at' => $this->produced_at,
            'version' => $this->version,
        ];
    }
}
