<?php

namespace App\Services\HerdEntryReason;

use App\Models\HerdEntryReason;
use \App\Services\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class HerdEntryReasonService extends Service
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

        return HerdEntryReason::query()->orderBy('id')->paginate(perPage: $perPage, page: $page);
    }

    public function update(array $validated, HerdEntryReason $herdEntryReason): ?HerdEntryReason
    {
        try {
            $result = $herdEntryReason->update($validated);
            if ($result) {
                return $herdEntryReason;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function store(mixed $data)
    {
        try {
            $herdEntryReason = HerdEntryReason::query()->create($data);
            if ($herdEntryReason) {
                return $herdEntryReason;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function show(HerdEntryReason $herdEntryReason): ?HerdEntryReason
    {
        try {
            return $herdEntryReason;
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    /**
     * @param HerdEntryReason $herdEntryReason
     * @return bool
     */
    public function delete(HerdEntryReason $herdEntryReason): bool
    {
        if ($herdEntryReason->animals()->exists()) {
            throw new \Exception('HerdEntryReason has animals');
        }

        try {
            $result = $herdEntryReason->delete();
            if ($result) {
                return true;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return false;
    }
}
