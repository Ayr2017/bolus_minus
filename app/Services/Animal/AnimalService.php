<?php

namespace App\Services\Animal;

use App\Models\Animal;
use App\Repositories\Animal\AnimalRepository;
use \App\Services\Service;
use Illuminate\Support\Facades\Log;

class AnimalService extends Service
{
    private AnimalRepository $animalRepository;
    public function __construct()
    {
        $this->animalRepository = new AnimalRepository();
        parent::__construct();
    }

    public function storeAnimal(array $data): ?Animal
    {
        $animal = Animal::query()->create($data);
        if ($animal) {
            return $animal;
        }
        return null;
    }

    public function update(array $validated, Animal $animal): ?Animal
    {
        try {
            $result = $animal->update($validated);
            if ($result) {
                return $animal;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return null;
    }

    public function index(mixed $validated)
    {
        return $this->animalRepository->getAnimals($validated);
    }

    public function deleteAnimal(int $animalId): bool
    {
        try {
            $animal = Animal::query()->findOrFail($animalId);
            $result = $animal->delete();
            if ($result) {
                return true;
            }
        } catch (\Exception $e) {
            Log::error(__METHOD__ . " " . $e->getMessage());
        }
        return false;
    }
}
