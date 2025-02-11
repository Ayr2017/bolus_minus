<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\HerdEntryReason\IndexHerdEntryReasonRequest;
use App\Http\Requests\HerdEntryReason\ShowHerdEntryReasonRequest;
use App\Http\Requests\HerdEntryReason\StoreHerdEntryReasonRequest;
use App\Http\Requests\HerdEntryReason\UpdateHerdEntryReasonRequest;
use App\Http\Requests\HerdEntryReason\DeleteHerdEntryReasonRequest;
use App\Http\Resources\HerdEntryReason\HerdEntryReasonResource;
use App\Http\Responses\ApiResponse;
use App\Models\HerdEntryReason;
use App\Services\HerdEntryReason\HerdEntryReasonService;
use Illuminate\Http\JsonResponse;

class HerdEntryReasonsController extends Controller
{
    /**
     * @param IndexHerdEntryReasonRequest $request
     * @param HerdEntryReasonService $herdEntryReasonService
     * @return JsonResponse
     */
    public function index(IndexHerdEntryReasonRequest $request, HerdEntryReasonService $herdEntryReasonService): JsonResponse
    {
        try {
            $herdEntryReasons = $herdEntryReasonService->index($request->validated());
            return ApiResponse::success(HerdEntryReasonResource::paginatedCollection($herdEntryReasons));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreHerdEntryReasonRequest $request
     * @param HerdEntryReasonService $herdEntryReasonService
     * @return JsonResponse
     */
    public function store(StoreHerdEntryReasonRequest $request, HerdEntryReasonService $herdEntryReasonService): JsonResponse
    {
        try {
            $herdEntryReason = $herdEntryReasonService->store($request->validated());
            return ApiResponse::success(new HerdEntryReasonResource($herdEntryReason));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowHerdEntryReasonRequest $request
     * @param HerdEntryReasonService $service
     * @param HerdEntryReason $herdEntryReason
     * @return JsonResponse
     */
    public function show(ShowHerdEntryReasonRequest $request, HerdEntryReasonService $service, HerdEntryReason $herdEntryReason): JsonResponse
    {
        try {
            $herdEntryReason = $service->show($herdEntryReason);
            return ApiResponse::success(['herdEntryReason' => new HerdEntryReasonResource($herdEntryReason)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateHerdEntryReasonRequest $request
     * @param HerdEntryReasonService $herdEntryReasonService
     * @param HerdEntryReason $herdEntryReason
     * @return JsonResponse
     */
    public function update(UpdateHerdEntryReasonRequest $request, HerdEntryReasonService $herdEntryReasonService, HerdEntryReason $herdEntryReason): JsonResponse
    {
        try {
            $herdEntryReason = $herdEntryReasonService->update($request->validated(), $herdEntryReason);
            return ApiResponse::success(['herdEntryReason' => new HerdEntryReasonResource($herdEntryReason)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteHerdEntryReasonRequest $request
     * @param HerdEntryReasonService $service
     * @param HerdEntryReason $herdEntryReason
     * @return JsonResponse
     */
    public function destroy(DeleteHerdEntryReasonRequest $request, HerdEntryReasonService $herdEntryReasonService, HerdEntryReason $herdEntryReason): JsonResponse
    {
        try {
            return ApiResponse::success($herdEntryReasonService->delete($herdEntryReason));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
