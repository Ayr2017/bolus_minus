<?php

namespace App\Http\Resources\Animal;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @property int $id
 * TODO: дописать
 */
class AnimalResource extends PaginatedJsonResponse
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
            'uuid' => $this->uuid,
            'name' => $this->name,
            'number' => $this->number,
            'organisation_id' => $this->organisation_id,
            'birthday' => $this->birthday ? $this->birthdayYmd : null,
            'breed_id' => $this->breed_id,

            'number_rshn' => $this->number_rshn,
            'bolus_id' => $this->bolus_id,
            'number_rf' => $this->number_rf,
            'number_tavro' => $this->number_tavro,
            'number_tag' => $this->number_tag,
            'tag_color' => $this->tag_color,
            'number_collar' => $this->number_collar,
            'status_id' => $this->status_id,
            'sex' => $this->sex,
            'withdrawn_at' => $this->withdrawn_at,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
        ];
    }

}
