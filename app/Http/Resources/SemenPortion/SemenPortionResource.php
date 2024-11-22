<?php

namespace App\Http\Resources\SemenPortion;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;

class SemenPortionResource extends PaginatedJsonResponse
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name',
            'description',
        ];
    }
}
