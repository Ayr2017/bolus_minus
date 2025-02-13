<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\SemenPortion\IndexSemenPortionRequest;
use App\Http\Requests\SemenPortion\ShowSemenPortionRequest;
use App\Http\Requests\SemenPortion\StoreSemenPortionRequest;
use App\Http\Requests\SemenPortion\UpdateSemenPortionRequest;
use App\Http\Requests\SemenPortion\DeleteSemenPortionRequest;
use App\Http\Resources\SemenPortion\SemenPortionResource;
use App\Http\Responses\ApiResponse;
use App\Models\SemenPortion;
use App\Services\SemenPortion\SemenPortionService;
use Illuminate\Http\JsonResponse;

class SemenPortionController extends Controller
{
    /**
     * @param IndexSemenPortionRequest $request
     * @param SemenPortionService $semenPortionService
     * @return JsonResponse
     */
    public function index(IndexSemenPortionRequest $request, SemenPortionService $semenPortionService): JsonResponse
    {
        try {
            $semenPortions = $semenPortionService->getSemenPortions($request->validated());
            return ApiResponse::success(SemenPortionResource::paginatedCollection($semenPortions));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreSemenPortionRequest $request
     * @param SemenPortionService $semenPortionService
     * @return JsonResponse
     */
    public function store(StoreSemenPortionRequest $request, SemenPortionService $semenPortionService): JsonResponse
    {
        try {
            $semenPortion = $semenPortionService->storeSemenPortion($request->validated());
            return ApiResponse::success(new SemenPortionResource($semenPortion));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowSemenPortionRequest $request
     * @param SemenPortionService $service
     * @param SemenPortion $semenPortion
     * @return JsonResponse
     */
    public function show(ShowSemenPortionRequest $request, SemenPortionService $service, SemenPortion $semenPortion): JsonResponse
    {
        try {
            $semenPortion = $service->show($semenPortion);
            return ApiResponse::success(['semenPortion' => new SemenPortionResource($semenPortion)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateSemenPortionRequest $request
     * @param SemenPortionService $semenPortionService
     * @param SemenPortion $semenPortion
     * @return JsonResponse
     */
    public function update(UpdateSemenPortionRequest $request, SemenPortionService $semenPortionService, SemenPortion $semenPortion): JsonResponse
    {
        try {
            $semenPortion = $semenPortionService->updateSemenPortion($request->validated(), $semenPortion);
            return ApiResponse::success(['semenPortion' => new SemenPortionResource($semenPortion)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteSemenPortionRequest $request
     * @param SemenPortionService $semenPortionService
     * @param SemenPortion $semenPortion
     * @return JsonResponse
     */
    public function destroy(DeleteSemenPortionRequest $request, SemenPortionService $semenPortionService, SemenPortion $semenPortion): JsonResponse
    {
        try {
            return ApiResponse::success($semenPortionService->deleteSemenPortion($semenPortion));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
