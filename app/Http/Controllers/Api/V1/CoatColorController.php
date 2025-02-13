<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\CoatColor\IndexCoatColorRequest;
use App\Http\Requests\CoatColor\ShowCoatColorRequest;
use App\Http\Requests\CoatColor\StoreCoatColorRequest;
use App\Http\Requests\CoatColor\UpdateCoatColorRequest;
use App\Http\Requests\CoatColor\DeleteCoatColorRequest;
use App\Http\Resources\CoatColor\CoatColorResource;
use App\Http\Responses\ApiResponse;
use App\Models\CoatColor;
use App\Services\CoatColor\CoatColorService;
use Illuminate\Http\JsonResponse;

class CoatColorController extends Controller
{
    /**
     * @param IndexCoatColorRequest $request
     * @param CoatColorService $coatColorService
     * @return JsonResponse
     */
    public function index(IndexCoatColorRequest $request, CoatColorService $coatColorService): JsonResponse
    {
        try {
            $coatColors = $coatColorService->index($request->validated());
            return ApiResponse::success(CoatColorResource::paginatedCollection($coatColors));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreCoatColorRequest $request
     * @param CoatColorService $coatColorService
     * @return JsonResponse
     */
    public function store(StoreCoatColorRequest $request, CoatColorService $coatColorService): JsonResponse
    {
        try {
            $coatColor = $coatColorService->store($request->validated());
            return ApiResponse::success(new CoatColorResource($coatColor));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowCoatColorRequest $request
     * @param CoatColorService $service
     * @param CoatColor $coatColor
     * @return JsonResponse
     */
    public function show(ShowCoatColorRequest $request, CoatColorService $service, CoatColor $coatColor): JsonResponse
    {
        try {
            $coatColor = $service->show($coatColor);
            return ApiResponse::success(new CoatColorResource($coatColor));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateCoatColorRequest $request
     * @param CoatColorService $coatColorService
     * @param CoatColor $coatColor
     * @return JsonResponse
     */
    public function update(UpdateCoatColorRequest $request, CoatColorService $coatColorService, CoatColor $coatColor): JsonResponse
    {
        try {
            $coatColor = $coatColorService->update($request->validated(), $coatColor);
            return ApiResponse::success(new CoatColorResource($coatColor));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteCoatColorRequest $request
     * @param CoatColorService $coatColorService
     * @param CoatColor $coatColor
     * @return JsonResponse
     */
    public function destroy(DeleteCoatColorRequest $request, CoatColorService $coatColorService, CoatColor $coatColor): JsonResponse
    {
        try {
            $coatColor = $coatColorService->delete($coatColor);
            return ApiResponse::success($coatColor);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
