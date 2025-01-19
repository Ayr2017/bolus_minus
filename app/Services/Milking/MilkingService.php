<?php

namespace App\Services\Milking;

use App\Models\Milking;
use \App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class MilkingService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function index(array $data): LengthAwarePaginator
    {
        $perPage = Arr::get($data, 'per_page', 50);
        $page = Arr::get($data, 'page', 1);

        return Milking::query()->orderBy('id')->with(['organization', 'department', 'shift'])->paginate(perPage: $perPage, page: $page);
    }

    public function update(array $validated, Milking $milking): ?Milking
    {
        try {
            $result = $milking->update($validated);
            if ($result) {
                return $milking->load('organization', 'department', 'shift');
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function store(mixed $data)
    {
        try {
            $milking = Milking::query()->create($data);
            if ($milking) {
                return $milking->load(['organization', 'department', 'shift']);
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function show(Milking $milking): ?Milking
    {
        try {
            return $milking->load(['organization', 'department', 'shift']);
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function delete(Milking $milking): bool
    {
        try {
            $result = $milking->delete();
            if ($result) {
                return true;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return false;
    }
}
