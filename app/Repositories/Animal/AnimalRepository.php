<?php

namespace App\Repositories\Animal;

use App\Http\Resources\Animal\AnimalResource;
use App\Models\Animal;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AnimalRepository
{

    public function getAnimals(mixed $validated): LengthAwarePaginator
    {
        $perPage = $validated['per_page'] ?? 10;
        $page = $validated['page'] ?? null;

        $query = QueryBuilder::for(Animal::class)
            ->allowedFilters([
                AllowedFilter::partial('number'),
                AllowedFilter::partial('number_rf'),
                AllowedFilter::partial('number_rshn'),
                AllowedFilter::partial('number_tavro'),
            ]);

        foreach (['number', 'number_rf', 'number_rshn', 'number_tavro'] as $field) {
            if (!empty($validated[$field])) {
                $query->where($field, 'like', '%' . $validated[$field] . '%');
            }
        }

        return $query->paginate($perPage);
    }
}
