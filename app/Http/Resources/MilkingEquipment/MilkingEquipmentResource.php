<?php

namespace App\Http\Resources\MilkingEquipment;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MilkingEquipmentResource extends PaginatedJsonResponse
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organization' => $this->whenLoaded('organization'),
            'department' => $this->whenLoaded('department'),
            'equipment_type' => $this->equipment_type,
            'milking_places_amount' => $this->milking_places_amount,
            'milking_per_day_amount' => $this->milking_per_day_amount,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
