<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animal\DeleteAnimalRequest;
use App\Http\Requests\Animal\GetAnimalsRequest;
use App\Http\Requests\Animal\ShowAnimalRequest;
use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Http\Resources\Animal\AnimalResource;
use App\Http\Resources\BolusResource;
use App\Http\Resources\Breed\BreedResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Http\Resources\StatusResource;
use App\Http\Responses\ApiResponse;
use App\Models\Animal;
use App\Models\Bolus;
use App\Models\Breed;
use App\Models\Organisation;
use App\Models\Status;
use App\Services\Animal\AnimalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AnimalsController extends Controller
{
    public function __construct(readonly AnimalService $animalService)
    {
    }

    /**
     * @param GetAnimalsRequest $request
     * @return JsonResponse
     */
    public function index(GetAnimalsRequest $request): JsonResponse
    {
        try {
            $animals = $this->animalService->getAnimals($request->validated());
            return ApiResponse::success(AnimalResource::paginatedCollection($animals));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     *
     * @return JsonResponse
     */
    public function create()
    {
        $organisations = OrganisationResource::collection(Organisation::all());
        $breeds = BreedResource::collection(Breed::all());
        $bolus = BolusResource::collection(Bolus::all());
        $status = StatusResource::collection(Status::all());
        return response()->json([
            'organisations' => $organisations,
            'breeds' => $breeds,
            'bolus' => $bolus,
            'status' => $status
        ]);
    }

    /**
     * @param StoreAnimalRequest $request
     * @return JsonResponse
     */
    public function store(StoreAnimalRequest $request)
    {
        try {
            $data = $request->validated();
            $animal = Animal::query()->create($data);
            return ApiResponse::success(AnimalResource::make($animal));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }
        return ApiResponse::error('Something went wrong!');

    }

    /**
     * @param ShowAnimalRequest $request
     * @return JsonResponse
     */
    public function show(ShowAnimalRequest $request, int $animal): JsonResponse
    {
        try {
            return ApiResponse::success(['animal' => AnimalResource::make(Animal::query()->find($animal))]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Show the form for editing the specified resource
     * @param Animal $animal
     */
    public function edit(Animal $animal)
    {
        $organisations = OrganisationResource::collection(Organisation::all());
        $breeds = BreedResource::collection(Breed::all());
        $bolus = BolusResource::collection(Bolus::all());
        $status = StatusResource::collection(Status::all());
        return response()->json([
            'animal' => $animal,
            'organisations' => $organisations,
            'breeds' => $breeds,
            'bolus' => $bolus,
            'status' => $status
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateAnimalRequest $request
     * @param Animal $animal
     * @return JsonResponse
     */
    public function update(UpdateAnimalRequest $request, Animal $animal): JsonResponse
    {
        try {
            $data = $request->validated();
            $animal->update($data);
            return ApiResponse::success(AnimalResource::make($animal));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }
        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param Animal $animal
     * @return JsonResponse
     */
    public function destroy(Animal $animal, DeleteAnimalRequest $request): JsonResponse
    {
        $animal->delete();
        return ApiResponse::success(AnimalResource::make($animal));
    }
}
