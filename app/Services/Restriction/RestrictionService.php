<?php

namespace App\Services\Restriction;

use App\Helpers\ErrorLog;
use App\Models\Restriction;
use \App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class RestrictionService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function deleteRestriction(Restriction $restriction):bool
    {
        try {
            $result  = $restriction->delete();
            if($result){
                return true;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__." ".$e->getMessage());
        }
        return false;
    }

    public function update(array $validated, Restriction $restriction): ?Restriction
    {
        try {
            dd($validated);

            $result = $restriction->update($validated);
            if($result){
                return $restriction;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__." ".$e->getMessage());
        }
        return null;
    }

    public function storeRestriction(mixed $data) :?Restriction
    {
        try {
            $restriction = Restriction::query()->create($data);

            if($restriction){
                return $restriction;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__." ".$e->getMessage());
        }
        return null;

    }

    /**
     * @param int $id
     * @return Restriction|null
     */
    public function show(int $id) : ?Restriction
    {
        try {
            $restriction = Restriction::query()->findOrFail($id);
            if($restriction){
                return $restriction;
            }
        }catch (\Exception $e){
            ErrorLog::write(__METHOD__, __LINE__, $e->getMessage());
        }

        return null;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getRestrictions(array $data): LengthAwarePaginator
    {
        $perPage = Arr::get($data, 'per_page', 50);
        $page = Arr::get($data, 'page', 1);

        return  Restriction::query()->orderBy('id')->paginate(perPage: $perPage, page: $page);
    }
}
