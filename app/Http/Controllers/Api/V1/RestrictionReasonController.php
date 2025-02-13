<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\RestrictionReason\DeleteRestrictionReasonRequest;
use App\Http\Requests\RestrictionReason\IndexRestrictionReasonRequest;
use App\Http\Requests\RestrictionReason\ShowRestrictionReasonRequest;
use App\Http\Requests\RestrictionReason\StoreRestrictionReasonRequest;
use App\Http\Requests\RestrictionReason\UpdateRestrictionReasonRequest;
use App\Http\Resources\RestrictionReason\RestrictionReasonResource;
use App\Http\Responses\ApiResponse;
use App\Models\RestrictionReason;
use App\Services\RestrictionReason\RestrictionReasonService;
use Illuminate\Http\JsonResponse;

class RestrictionReasonController extends Controller
{
    /**
     * @param IndexRestrictionReasonRequest $request
     * @param RestrictionReasonService $restrictionReasonService
     * @return JsonResponse
     */
    public function index(IndexRestrictionReasonRequest $request, RestrictionReasonService $restrictionReasonService): JsonResponse
    {
        try {
            $restrictionReasons = $restrictionReasonService->getRestrictionReasons($request->validated());
            return ApiResponse::success(RestrictionReasonResource::paginatedCollection($restrictionReasons));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreRestrictionReasonRequest $request
     * @param  RestrictionReasonService $restrictionReasonService
     * @return JsonResponse
     */
    public function store(StoreRestrictionReasonRequest $request, RestrictionReasonService $restrictionReasonService): JsonResponse
    {
        try {
            $restrictionReason = $restrictionReasonService->storeRestrictionReason($request->validated());

            return ApiResponse::success(new RestrictionReasonResource($restrictionReason));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowRestrictionReasonRequest $request
     * @param RestrictionReasonService $service
     * @param RestrictionReason $restrictionReason
     * @return JsonResponse
     */
    public function show(ShowRestrictionReasonRequest $request, RestrictionReasonService $service, RestrictionReason $restrictionReason): JsonResponse
    {
        try {
            $restrictionReason = $service->show($restrictionReason);
            return ApiResponse::success(['restrictionReason' => RestrictionReasonResource::make($restrictionReason)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRestrictionReasonRequest $request
     * @param RestrictionReasonService $restrictionReasonService
     * @param RestrictionReason $restrictionReason
     * @return JsonResponse
     */
    public function update(UpdateRestrictionReasonRequest $request, RestrictionReasonService $restrictionReasonService, RestrictionReason $restrictionReason): JsonResponse
    {
        try {
            $restrictionReason = $restrictionReasonService->updateRestrictionReason($request->validated(), $restrictionReason);
            return ApiResponse::success(['restrictionReason' => RestrictionReasonResource::make($restrictionReason)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteRestrictionReasonRequest $request
     * @param RestrictionReasonService $restrictionReasonService
     * @param RestrictionReason $restrictionReason
     * @return JsonResponse
     */
    public function destroy(DeleteRestrictionReasonRequest $request, RestrictionReasonService $restrictionReasonService,  RestrictionReason $restrictionReason): JsonResponse
    {
        try {
            return ApiResponse::success($restrictionReasonService->deleteRestrictionReason($restrictionReason));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
