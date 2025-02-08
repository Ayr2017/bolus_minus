<?php

namespace App\Services\AnimalGroup;

use App\Models\AnimalGroup;
use \App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnimalGroupService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $animalGroupId
     * @return bool
     */
    public function deleteAnimalGroup(int $animalGroupId):bool
    {
        try {
            $animalGroup = AnimalGroup::query()->findOrFail($animalGroupId);
            $result  = $animalGroup->delete();
            if($result){
                return true;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__." ".$e->getMessage());
        }
        return false;
    }

    /**
     * @param array $validated
     * @param int $animalGroupID
     * @return AnimalGroup|null
     */
    public function updateAnimalGroup(array $validated, int $animalGroupID): ?AnimalGroup
    {
        try {
            $animalGroup = AnimalGroup::query()->findOrFail($animalGroupID);
            $result = $animalGroup->update($validated);
            if($result){
                return $animalGroup;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__." ".$e->getMessage());
        }
        return null;
    }

    /**
     * @param mixed $data
     * @return AnimalGroup|\Illuminate\Database\Eloquent\Model|null
     */
    public function storeAnimalGroup(mixed $data)
    {

        try {
            $animalGroup = AnimalGroup::query()->create($data);
            if($animalGroup){
                return $animalGroup;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__." ".$e->getMessage());
        }
        return null;

    }

    /**
     * @param int $id
     * @return AnimalGroup|null
     */
    public function show(AnimalGroup $animalGroup):?AnimalGroup
    {
        try {
            return  $animalGroup;
        }catch (\Exception $e){
            Log::error(__METHOD__." ".$e->getMessage());
        }

        return null;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function getAnimalGroups(array $data): LengthAwarePaginator
    {
        $perPage = Arr::get($data, 'per_page', 50);
        $page = Arr::get($data, 'page', 1);

        return  AnimalGroup::query()->orderBy('id')->paginate(perPage: $perPage, page: $page);
    }
}
