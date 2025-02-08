<?php

namespace App\Services\Bolus;

use App\Models\Bolus;
use \App\Services\Service;
use Illuminate\Support\Facades\Log;

class BolusService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    public function storeBolus(array $data): ?Bolus
    {
        try {
            $bolus = Bolus::query()->create($data);
            if ($bolus) {
                return $bolus;
            }
        } catch (\Exception $exception) {
            Log::error(__METHOD__ . " " . $exception->getMessage());
        }

        return null;
    }

    public function updateBolus(array $data, Bolus $bolus): ?Bolus
    {
        try {
            $result = $bolus->update($data);
            if ($result) {
                return $bolus;
            }
        } catch (\Exception $exception) {
            Log::error(__METHOD__ . " " . $exception->getMessage());
        }

        return null;
    }

    public function deleteBolus(Bolus $bolus): bool
    {
        try {
            $result = $bolus->delete();
            if($result){
                return true;
            }
        }catch (\Exception $exception){
            Log::error(__METHOD__ . " " . $exception->getMessage());
        }
        return false;
    }

    public function index(mixed $validated)
    {
    }

    public function store(mixed $validated)
    {
    }

    public function show(Bolus $bolus)
    {
    }
}
