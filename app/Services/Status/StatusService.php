<?php

namespace App\Services\Status;

use App\Models\Breed;
use App\Models\Status;
use \App\Services\Service;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class StatusService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function storeStatus(array $data): ?Status
    {
        $status = Status
            ::query()
            ->create($data);
        try {


            if ($status) {
                return $status;
            }
        } catch (\Throwable $throwable) {
            Log::error(message: __METHOD__ . " " . $throwable->getMessage());
        }

        return null;
    }

    public function updateStatus(array $validated, Status $status): ?Status
    {
        try {
            $result = $status->update($validated);
            if ($result) {
                return $status;
            }
        } catch (\Throwable $throwable) {
            Log::error(message: __METHOD__ . " " . $throwable->getMessage());
        }

        return null;

    }

    public function deleteStatus(array $validated, Status $status):bool
    {
        try {
            $result = $status->delete();
            if($result){
                return true;
            }
        }catch (\Throwable $throwable){
            Log::error(message: __METHOD__ . " " . $throwable->getMessage());
        }

        return false;
    }

    public function index(array $validatedData): LengthAwarePaginator
    {
        $perPage = Arr::get($validatedData, 'per_page', 50);
        $page = Arr::get($validatedData, 'page', 1);

        return  Status::query()->orderBy('id')->paginate(perPage: $perPage, page: $page);
    }
}
