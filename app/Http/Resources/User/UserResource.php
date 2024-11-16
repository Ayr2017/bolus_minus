<?php

namespace App\Http\Resources\User;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class UserResource extends PaginatedJsonResponse
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
            'name' => $this->name ?? null,
            'surname' => $this->surname?? null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'created_at' => $this->created_at?->toDateTimeString() ?? null,
        ];
    }
}
