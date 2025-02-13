<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\SelectedBreedingBull\IndexSelectedBreedingBullRequest;
use App\Http\Requests\SelectedBreedingBull\ShowSelectedBreedingBullRequest;
use App\Http\Requests\SelectedBreedingBull\StoreSelectedBreedingBullRequest;
use App\Http\Requests\SelectedBreedingBull\UpdateSelectedBreedingBullRequest;
use App\Http\Requests\SelectedBreedingBull\DeleteSelectedBreedingBullRequest;
use App\Http\Resources\SelectedBreedingBull\SelectedBreedingBullResource;
use App\Http\Responses\ApiResponse;
use App\Models\SelectedBreedingBull;
use App\Services\SelectedBreedingBull\SelectedBreedingBullService;
use Illuminate\Http\JsonResponse;

class SelectedBreedingBullController extends Controller
{
    /**
     * @param IndexSelectedBreedingBullRequest $request
     * @param SelectedBreedingBullService $selectedBreedingBullService
     * @return JsonResponse
     */
    public function index(IndexSelectedBreedingBullRequest $request, SelectedBreedingBullService $selectedBreedingBullService): JsonResponse
    {
        try {
            $selectedBreedingBulls = $selectedBreedingBullService->index($request->validated());
            return ApiResponse::success(SelectedBreedingBullResource::paginatedCollection($selectedBreedingBulls));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSelectedBreedingBullRequest $request
     * @param SelectedBreedingBullService $selectedBreedingBullService
     * @return JsonResponse
     */
    public function store(StoreSelectedBreedingBullRequest $request, SelectedBreedingBullService $selectedBreedingBullService): JsonResponse
    {
        try {
            $selectedBreedingBull = $selectedBreedingBullService->store($request->validated());
            return ApiResponse::success(new SelectedBreedingBullResource($selectedBreedingBull));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowSelectedBreedingBullRequest $request
     * @param SelectedBreedingBullService $service
     * @param SelectedBreedingBull $selectedBreedingBull
     * @return JsonResponse
     */
    public function show(ShowSelectedBreedingBullRequest $request, SelectedBreedingBullService $service, SelectedBreedingBull $selectedBreedingBull): JsonResponse
    {
        try {
            $selectedBreedingBull = $service->show($selectedBreedingBull);
            return ApiResponse::success(['selectedBreedingBull' => new SelectedBreedingBullResource($selectedBreedingBull)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateSelectedBreedingBullRequest $request
     * @param SelectedBreedingBullService $selectedBreedingBullService
     * @param SelectedBreedingBull $selectedBreedingBull
     * @return JsonResponse
     */
    public function update(UpdateSelectedBreedingBullRequest $request, SelectedBreedingBullService $selectedBreedingBullService, SelectedBreedingBull $selectedBreedingBull): JsonResponse
    {
        try {
            $selectedBreedingBull = $selectedBreedingBullService->update($request->validated(), $selectedBreedingBull);
            return ApiResponse::success(['selectedBreedingBull' => new SelectedBreedingBullResource($selectedBreedingBull)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteSelectedBreedingBullRequest $request
     * @param SelectedBreedingBullService $selectedBreedingBullService
     * @param SelectedBreedingBull $selectedBreedingBull
     * @return JsonResponse
     */
    public function destroy(DeleteSelectedBreedingBullRequest $request, SelectedBreedingBullService $selectedBreedingBullService, SelectedBreedingBull $selectedBreedingBull): JsonResponse
    {
        try {
            $selectedBreedingBull = $selectedBreedingBullService->delete($selectedBreedingBull);
            return ApiResponse::success($selectedBreedingBull);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
