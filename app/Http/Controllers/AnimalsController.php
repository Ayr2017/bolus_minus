<?php

namespace App\Http\Controllers;

use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Models\Animal;
use App\Models\Bolus;
use App\Models\Breed;
use App\Models\Organisation;
use App\Models\Status;
use App\Services\Animal\AnimalService;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;

class AnimalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View|Factory
     */
    public function index(): View|Factory
    {
        $animals = Animal::query()->orderBy('name')->get();
        $title = "Animals";
        return view('animals.index', compact('animals', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organisations = Organisation::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $breeds = Breed::orderBy('name')->get();
        $boluses = Bolus::orderBy('number')->get();

        return view('animals.create', [
            'organisations' => $organisations,
            'statuses' => $statuses,
            'breeds' => $breeds,
            'boluses' => $boluses,
            'title' => "Add Animal",
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalRequest $request)
    {
        $validatedData = $request->validated();

        $animal = Animal::firstOrCreate(['number' => $validatedData['number']], $validatedData);
        return redirect()->route('animals.index')->with('message', 'Animal created successfully.')->with('created_animal', $animal);
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {
        return view('animals.show', [
            'animal' => $animal,
            'title' => "Animals"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Animal $animal)
    {
        $organisations = Organisation::orderBy('name')->get();
        $statuses = Status::orderBy('name')->get();
        $breeds = Breed::orderBy('name')->get();
        $boluses = Bolus::orderBy('number')->get();

        return view('animals.edit', [
            'animal' => $animal,
            'organisations' => $organisations,
            'statuses' => $statuses,
            'breeds' => $breeds,
            'boluses' => $boluses,
            'title' => "Edit Animal",
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalRequest $request, Animal $animal, AnimalService $animalService)
    {
        $animal = $animalService->updateAnimal($request->validated(), $animal);
        if ($animal) {
            return redirect()->route('animals.index')->with('message', 'Animal updated successfully.');
        }
        return redirect()->back()->withErrors(['message' => 'Something went wrong.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal, AnimalService $animalService)
    {
        $deleted = $animalService->deleteAnimal($animal);

        if ($deleted) {
            return redirect()->route('animals.index')->with('message', 'Animal deleted successfully.');
        }

        return redirect()->back()->withErrors(['message' => 'Something went wrong.']);
    }
}
