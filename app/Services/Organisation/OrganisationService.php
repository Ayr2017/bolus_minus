<?php

namespace App\Services\Organisation;

use App\Models\BreedingBull;
use App\Models\Organisation;
use \App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrganisationService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(array $data): LengthAwarePaginator
    {
        $perPage = Arr::get($data, 'per_page', 50);
        $page = Arr::get($data, 'page', 1);

        return QueryBuilder::for(Organisation::class)
            ->allowedFilters([
                AllowedFilter::exact('name'),
                AllowedFilter::exact('structural_unit_id'),
                AllowedFilter::exact('parent_id'),
                AllowedFilter::exact('is_active'),
            ])
            ->paginate(perPage: $perPage, page: $page);

    }

    public function storeOrganisation(array $data):?Organisation
    {
        try {
            $organisation = Organisation::query()->create($data);
            if($organisation){
                return $organisation;
            }
        }catch (\Throwable $throwable){
            Log::error(__METHOD__." ".$throwable->getMessage());
        }
        return null;
    }

    public function show(Organisation $organisation): ?Organisation
    {
        try {
            return $organisation;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function updateOrganisation(array $validated, Organisation $organisation): ?Organisation
    {
        try {
            $result = $organisation->update($validated);
            if($result){
                return $organisation;
            }
        }catch (\Throwable $throwable){
            Log::error(__METHOD__." ".$throwable->getMessage());
        }
        return null;
    }

    public function delete(Organisation $organisation): ?Organisation
    {
        try {
            $result = $organisation->delete();
            if($result){
                return $organisation;
            }
        }catch (\Throwable $throwable){
            Log::error(__METHOD__." ".$throwable->getMessage());
        }
        return null;
    }

}
