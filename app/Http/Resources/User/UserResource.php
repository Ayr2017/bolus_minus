<?php

namespace App\Http\Resources\User;

use App\Http\Resources\PaginatedJsonResponse;
use Illuminate\Http\Request;

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
            'surname' => $this->surname ?? null,
            'email' => $this->email ?? null,
            'phone' => $this->phone ?? null,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'lastname' => $this->lastname ?? null,
            'roles' => $this->getRoleNames() ?? null,
            'organisations' => $this->employees->pluck('organisation')
        ];
    }
}
