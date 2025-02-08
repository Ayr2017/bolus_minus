<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animal\IndexAnimalsRequest;
use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\ShowAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Http\Requests\Animal\DeleteAnimalRequest;
use App\Http\Resources\Animal\AnimalResource;
use App\Http\Responses\ApiResponse;
use App\Models\Animal;
use App\Services\Animal\AnimalService;
use Illuminate\Http\JsonResponse;

class AnimalsController extends Controller
{
    public function __construct(readonly AnimalService $animalService) {}

    /**
     * @param IndexAnimalsRequest $request
     * @return JsonResponse
     */
    public function index(IndexAnimalsRequest $request): JsonResponse
    {
        try {
            $animals = $this->animalService->index($request->validated());
            return ApiResponse::success(AnimalResource::paginatedCollection($animals));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param StoreAnimalRequest $request
     * @return JsonResponse
     */
    public function store(StoreAnimalRequest $request): JsonResponse
    {
        try {
            $animal = $this->animalService->storeAnimal($request->validated());
            if ($animal) {
                return ApiResponse::success(AnimalResource::make($animal));
            }
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
            return ApiResponse::error($throwable->getMessage());
        }
        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowAnimalRequest $request
     * @param Animal $animal
     * @return JsonResponse
     */
    public function show(ShowAnimalRequest $request, Animal $animal): JsonResponse
    {
        try {
            $animal = $this->animalService->show($animal);
            return ApiResponse::success(['animal' => new AnimalResource($animal)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param UpdateAnimalRequest $request
     * @param Animal $animal
     * @return JsonResponse
     */
    public function update(UpdateAnimalRequest $request,  Animal $animal): JsonResponse
    {
        try {
            $animal = $this->animalService->update($request->validated(), $animal);
            return ApiResponse::success(new AnimalResource($animal));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param DeleteCoatColorRequest $request
     * @param Animal $animal
     * @return JsonResponse
     */
    public function destroy(DeleteAnimalRequest $request,  Animal $animal): JsonResponse
    {
        try {
            $animal = $this->animalService->delete($animal);
            return ApiResponse::success($animal);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
