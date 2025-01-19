<?php

namespace App\Services\Animal;

use App\Models\Animal;
use App\Repositories\Animal\AnimalRepository;
use \App\Services\Service;

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

    public function updateAnimal(array $data, Animal $animal): ?Animal
    {
        $result = $animal->update($data);
        if ($result) {
            return $animal;
        }
        return null;
    }

    public function getAnimals(mixed $validated)
    {
        return $this->animalRepository->getAnimals($validated);
    }

    public function deleteAnimal(Animal $animal)
    {
        try {
            return $animal->delete();
        } catch (\Exception $e) {
            return false;
        }
    }
}
