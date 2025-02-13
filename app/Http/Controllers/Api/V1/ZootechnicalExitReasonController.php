<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\ZootechnicalExitReason\IndexZootechnicalExitReasonRequest;
use App\Http\Requests\ZootechnicalExitReason\ShowZootechnicalExitReasonRequest;
use App\Http\Requests\ZootechnicalExitReason\StoreZootechnicalExitReasonRequest;
use App\Http\Requests\ZootechnicalExitReason\UpdateZootechnicalExitReasonRequest;
use App\Http\Requests\ZootechnicalExitReason\DeleteZootechnicalExitReasonRequest;
use App\Http\Resources\ZootechnicalExitReason\ZootechnicalExitReasonResource;
use App\Http\Responses\ApiResponse;
use App\Models\ZootechnicalExitReason;
use App\Services\ZootechnicalExitReason\ZootechnicalExitReasonService;
use Illuminate\Http\JsonResponse;

class ZootechnicalExitReasonController extends Controller
{
    /**
     * @param IndexZootechnicalExitReasonRequest $request
     * @param ZootechnicalExitReasonService $zootechnicalExitReasonService
     * @return JsonResponse
     */
    public function index(IndexZootechnicalExitReasonRequest $request, ZootechnicalExitReasonService $zootechnicalExitReasonService): JsonResponse
    {
        try {
            $zootechnicalExitReasons = $zootechnicalExitReasonService->index($request->validated());
            return ApiResponse::success(ZootechnicalExitReasonResource::paginatedCollection($zootechnicalExitReasons));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreZootechnicalExitReasonRequest $request
     * @param ZootechnicalExitReasonService $zootechnicalExitReasonService
     * @return JsonResponse
     */
    public function store(StoreZootechnicalExitReasonRequest $request, ZootechnicalExitReasonService $zootechnicalExitReasonService): JsonResponse
    {
        try {
            $zootechnicalExitReason = $zootechnicalExitReasonService->store($request->validated());
            return ApiResponse::success(new ZootechnicalExitReasonResource($zootechnicalExitReason));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowZootechnicalExitReasonRequest $request
     * @param ZootechnicalExitReasonService $service
     * @param ZootechnicalExitReason $zootechnicalExitReason
     * @return JsonResponse
     */
    public function show(ShowZootechnicalExitReasonRequest $request, ZootechnicalExitReasonService $service, ZootechnicalExitReason $zootechnicalExitReason): JsonResponse
    {
        try {
            $zootechnicalExitReason = $service->show($zootechnicalExitReason);
            return ApiResponse::success(['zootechnicalExitReason' => new ZootechnicalExitReasonResource($zootechnicalExitReason)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateZootechnicalExitReasonRequest $request
     * @param ZootechnicalExitReasonService $zootechnicalExitReasonService
     * @param ZootechnicalExitReason $zootechnicalExitReason
     * @return JsonResponse
     */
    public function update(UpdateZootechnicalExitReasonRequest $request, ZootechnicalExitReasonService $zootechnicalExitReasonService, ZootechnicalExitReason $zootechnicalExitReason): JsonResponse
    {
        try {
            $zootechnicalExitReason = $zootechnicalExitReasonService->update($request->validated(), $zootechnicalExitReason);
            return ApiResponse::success([new ZootechnicalExitReasonResource($zootechnicalExitReason)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteZootechnicalExitReasonRequest $request
     * @param ZootechnicalExitReasonService $service
     * @param ZootechnicalExitReason $zootechnicalExitReason
     * @return JsonResponse
     */
    public function destroy(DeleteZootechnicalExitReasonRequest $request, ZootechnicalExitReasonService $zootechnicalExitReasonService, ZootechnicalExitReason $zootechnicalExitReason): JsonResponse
    {
        try {
            $zootechnicalExitReason = $zootechnicalExitReasonService->delete($zootechnicalExitReason);
            return ApiResponse::success($zootechnicalExitReason);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
