<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\StructuralUnit\IndexStructuralUnitRequest;
use App\Http\Requests\StructuralUnit\ShowStructuralUnitRequest;
use App\Http\Requests\StructuralUnit\StoreStructuralUnitRequest;
use App\Http\Requests\StructuralUnit\UpdateStructuralUnitRequest;
use App\Http\Requests\StructuralUnit\DeleteStructuralUnitRequest;
use App\Http\Resources\StructuralUnit\StatusResource;
use App\Http\Responses\ApiResponse;
use App\Models\StructuralUnit;
use App\Services\StructuralUnit\StructuralUnitService;
use Illuminate\Http\JsonResponse;

class StructuralUnitsController extends Controller
{
    /**
     * @param IndexStructuralUnitRequest $request
     * @param StructuralUnitService $structuralUnitService
     * @return JsonResponse
     */
    public function index(IndexStructuralUnitRequest $request, StructuralUnitService $structuralUnitService): JsonResponse
    {
        try {
            $structuralUnits = $structuralUnitService->index($request->validated());
            return ApiResponse::success(StatusResource::paginatedCollection($structuralUnits));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreStructuralUnitRequest $request
     * @param StructuralUnitService $structuralUnitService
     * @return JsonResponse
     */
    public function store(StoreStructuralUnitRequest $request, StructuralUnitService $structuralUnitService): JsonResponse
    {
        try {
            $structuralUnit = $structuralUnitService->store($request->validated());
            return ApiResponse::success(new StatusResource($structuralUnit));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowStructuralUnitRequest $request
     * @param StructuralUnitService $service
     * @param StructuralUnit $structuralUnit
     * @return JsonResponse
     */
    public function show(ShowStructuralUnitRequest $request, StructuralUnitService $service, StructuralUnit $structuralUnit): JsonResponse
    {
        try {
            $structuralUnit = $service->show($structuralUnit);
            return ApiResponse::success(StatusResource::make($structuralUnit));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateStructuralUnitRequest $request
     * @param StructuralUnitService $structuralUnitService
     * @param StructuralUnit $structuralUnit
     * @return JsonResponse
     */
    public function update(UpdateStructuralUnitRequest $request, StructuralUnitService $structuralUnitService, StructuralUnit $structuralUnit): JsonResponse
    {
        try {
            $structuralUnit = $structuralUnitService->update($request->validated(), $structuralUnit);
            return ApiResponse::success(['structuralUnit' => new StatusResource($structuralUnit)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteStructuralUnitRequest $request
     * @param StructuralUnitService $service
     * @param StructuralUnit $structuralUnit
     * @return JsonResponse
     */
    public function destroy(DeleteStructuralUnitRequest $request, StructuralUnitService $structuralUnitService, StructuralUnit $structuralUnit): JsonResponse
    {
        try {
            $structuralUnit = $structuralUnitService->delete($structuralUnit);
            return ApiResponse::success($structuralUnit);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
