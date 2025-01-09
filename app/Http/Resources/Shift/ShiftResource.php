<?php

namespace App\Http\Resources\Shift;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShiftResource extends PaginatedJsonResponse
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
            'name' => $this->name,
            'organization' => $this->whenLoaded('organization'),
            'department' => $this->whenLoaded('department'),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
