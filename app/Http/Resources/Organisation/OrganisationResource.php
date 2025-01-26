<?php

namespace App\Http\Resources\Organisation;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;

class OrganisationResource extends PaginatedJsonResponse
{
    /**
     * Converts the model instance to an array for API response.
     *
     * @param Request $request The HTTP request instance.
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'parent' => $this->parent,
            'structural_unit' => $this->structuralUnit,
            'structural_unit_id' => $this->structural_unit_id,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at?->toDateTimeString(),
            'updated_at' => $this->updated_at?->toDateTimeString(),
            'organisations' => $this->organisations,
            'inn' => $this->inn,
            'region' => $this->region,
            'adress' => $this->adress,
            'abbreviated' => $this->abbreviated,
            'district' => $this->district,
            'category_name' => $this->name_category ?? null,
            'department' => $this->department
        ];
    }
}
