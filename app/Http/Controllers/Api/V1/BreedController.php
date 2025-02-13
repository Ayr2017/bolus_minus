<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Breed\DeleteBreedRequest;
use App\Http\Requests\Breed\IndexBreedRequest;
use App\Http\Requests\Breed\ShowBreadRequest;
use App\Http\Requests\Breed\StoreBreedRequest;
use App\Http\Requests\Breed\UpdateBreedRequest;
use App\Http\Resources\Breed\BreedResource;
use App\Http\Responses\ApiResponse;
use App\Models\Breed;
use App\Services\Breed\BreedService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BreedController extends Controller
{
    /**
     * @param IndexBreedRequest $request
     * @param BreedService $breedService
     * @return JsonResponse
     */
    public function index(IndexBreedRequest $request, BreedService $breedService): JsonResponse
    {
        try {
            $breeds = $breedService->getBreeds($request->validated());
            return ApiResponse::success(BreedResource::paginatedCollection($breeds));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreBreedRequest $request
     * @param  BreedService $breedService
     * @return JsonResponse
     */
    public function store(StoreBreedRequest $request, BreedService $breedService): JsonResponse
    {
        try {
            $breed = $breedService->storeBreed($request->validated());

            return ApiResponse::success(new BreedResource($breed));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Display the specified resource.
     * @param int $breed
     * @param ShowBreadRequest $request
     * @param BreedService $service
     * @return JsonResponse
     */
    public function show(ShowBreadRequest $request, BreedService $service, int $breed): JsonResponse
    {
        try {
            $breed = $service->show($breed);
            return ApiResponse::success(['breed' => BreedResource::make($breed)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateBreedRequest $request
     * @param int $breed
     * @param BreedService $breedService
     * @return JsonResponse
     */
    public function update(UpdateBreedRequest $request, BreedService $breedService, int $breed): JsonResponse
    {
        try {
            $breed = $breedService->updateBreed($request->validated(), $breed);

            return ApiResponse::success(['breed' => BreedResource::make($breed)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteBreedRequest $request
     * @param int $breed
     * @param BreedService $service
     * @return JsonResponse
     */
    public function destroy(DeleteBreedRequest $request, BreedService $breedService,  int $breed): JsonResponse
    {
        try {
            return ApiResponse::success($breedService->deleteBreed($breed));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
