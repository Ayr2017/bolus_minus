<?php

namespace App\Http\Resources\TagColor;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class TagColorResource extends PaginatedJsonResponse
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
            'slug' => $this->slug,
            'hex' => $this->hex,
        ];
    }
}
