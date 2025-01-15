<?php

namespace App\Http\Resources\Restriction;

use App\Http\Resources\PaginatedJsonResponse;
use App\Modules\Event\DataObject\EventDataObjectFactory;
use Illuminate\Http\Request;

class RestrictionResource extends PaginatedJsonResponse
{
    /**
     * @throws \Exception
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString()
        ];
    }
}
