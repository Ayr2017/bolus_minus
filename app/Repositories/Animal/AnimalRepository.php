<?php

namespace App\Repositories\Animal;

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
                AllowedFilter::partial('number_rshn'),
                AllowedFilter::partial('number_tavro'),
                AllowedFilter::partial('bolus.number'),
                AllowedFilter::partial('uuid'),
                AllowedFilter::exact('bolus_active'),
            ])
            ->with('bolus');

        foreach (['number', 'number_rf', 'number_rshn', 'number_tavro'] as $field) {
            if (!empty($validated[$field])) {
                $query->where($field, 'like', '%' . $validated[$field] . '%');
            }
        }

        if (!empty($validated['bolus_number'])) {
            $query->whereHas('bolus', function ($q) use ($validated) {
                $q->where('number', 'like', '%' . $validated['bolus_number'] . '%');
            });
        }
        if (isset($validated['bolus_active'])) {
            if ($validated['bolus_active'] === true) {
                $query->whereNotNull('bolus_id');
            } else $query->whereNull('bolus_id');
        }
        return $query->paginate($perPage);
    }
}
