<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\BreedingBull\IndexBreedingBullRequest;
use App\Http\Requests\BreedingBull\ShowBreedingBullRequest;
use App\Http\Requests\BreedingBull\StoreBreedingBullRequest;
use App\Http\Requests\BreedingBull\UpdateBreedingBullRequest;
use App\Http\Requests\BreedingBull\DeleteBreedingBullRequest;
use App\Http\Resources\BreedingBull\BreedingBullResource;
use App\Http\Responses\ApiResponse;
use App\Models\BreedingBull;
use App\Services\BreedingBull\BreedingBullService;
use Illuminate\Http\JsonResponse;

class BreedingBullController extends Controller
{
    /**
     * @param IndexBreedingBullRequest $request
     * @param BreedingBullService $breedingBullService
     * @return JsonResponse
     */
    public function index(IndexBreedingBullRequest $request, BreedingBullService $breedingBullService): JsonResponse
    {
        try {
            $breedingBulls = $breedingBullService->index($request->validated());
            return ApiResponse::success(BreedingBullResource::paginatedCollection($breedingBulls));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreBreedingBullRequest $request
     * @param BreedingBullService $breedingBullService
     * @return JsonResponse
     */
    public function store(StoreBreedingBullRequest $request, BreedingBullService $breedingBullService): JsonResponse
    {
        try {
            $breedingBull = $breedingBullService->store($request->validated());
            return ApiResponse::success(new BreedingBullResource($breedingBull));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowBreedingBullRequest $request
     * @param BreedingBullService $service
     * @param BreedingBull $breedingBull
     * @return JsonResponse
     */
    public function show(ShowBreedingBullRequest $request, BreedingBullService $service, BreedingBull $breedingBull): JsonResponse
    {
        try {
            $breedingBull = $service->show($breedingBull);
            return ApiResponse::success(BreedingBullResource::make($breedingBull));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateBreedingBullRequest $request
     * @param BreedingBullService $breedingBullService
     * @param BreedingBull $breedingBull
     * @return JsonResponse
     */
    public function update(UpdateBreedingBullRequest $request, BreedingBullService $breedingBullService, BreedingBull $breedingBull): JsonResponse
    {
        try {
            $breedingBull = $breedingBullService->update($request->validated(), $breedingBull);
            return ApiResponse::success(new BreedingBullResource($breedingBull));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteBreedingBullRequest $request
     * @param BreedingBullService $service
     * @param BreedingBull $breedingBull
     * @return JsonResponse
     */
    public function destroy(DeleteBreedingBullRequest $request, BreedingBullService $breedingBullService, BreedingBull $breedingBull): JsonResponse
    {
        try {
            $breedingBull = $breedingBullService->delete($breedingBull);
            return ApiResponse::success($breedingBull);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * @param IndexBreedingBullRequest $request
     * @param BreedingBullService $breedingBullService
     * @return JsonResponse
     */
    //TODO: на консервации
    //    public function selectedBreedingBulls(IndexBreedingBullRequest $request, BreedingBullService $breedingBullService) :JsonResponse
    //    {
    //        try {
    //            $breedingBulls = $breedingBullService->selectedBreedingBulls($request->validated());
    //            return ApiResponse::success(BreedingBullResource::paginatedCollection($breedingBulls));
    //        } catch (\Throwable $throwable) {
    //            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
    //        }
    //
    //        return ApiResponse::error('Something went wrong!');
    //    }
}
