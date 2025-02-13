<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\InseminationMethod\DeleteInseminationMethodRequest;
use App\Http\Requests\InseminationMethod\IndexInseminationMethodRequest;
use App\Http\Requests\InseminationMethod\ShowInseminationMethodRequest;
use App\Http\Requests\InseminationMethod\StoreInseminationMethodRequest;
use App\Http\Requests\InseminationMethod\UpdateInseminationMethodRequest;
use App\Http\Resources\InseminationMethod\InseminationMethodResource;
use App\Http\Responses\ApiResponse;
use App\Models\InseminationMethod;
use App\Services\InseminationMethod\InseminationMethodService;
use Illuminate\Http\JsonResponse;

class InseminationMethodController extends Controller
{
    /**
     * @param IndexInseminationMethodRequest $request
     * @param InseminationMethodService $inseminationMethodService
     * @return JsonResponse
     */
    public function index(IndexInseminationMethodRequest $request, InseminationMethodService $inseminationMethodService): JsonResponse
    {
        try {
            $inseminationMethods = $inseminationMethodService->getInseminationMethods($request->validated());
            return ApiResponse::success(InseminationMethodResource::paginatedCollection($inseminationMethods));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * @param StoreInseminationMethodRequest $request
     * @param InseminationMethodService $inseminationMethodService
     * @return JsonResponse
     */
    public function store(StoreInseminationMethodRequest $request, InseminationMethodService $inseminationMethodService): JsonResponse
    {
        try {
            $inseminationMethod = $inseminationMethodService->storeInseminationMethod($request->validated());
            return ApiResponse::success(new InseminationMethodResource($inseminationMethod));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowInseminationMethodRequest $request
     * @param InseminationMethodService $service
     * @param InseminationMethod $inseminationMethod
     * @return JsonResponse
     */
    public function show(ShowInseminationMethodRequest $request, InseminationMethodService $service, InseminationMethod $inseminationMethod): JsonResponse
    {
        try {
            $inseminationMethod = $service->show($inseminationMethod);
            return ApiResponse::success([InseminationMethodResource::make($inseminationMethod)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateInseminationMethodRequest $request
     * @param InseminationMethodService $inseminationMethodService
     * @param InseminationMethod $inseminationMethod
     * @return JsonResponse
     */
    public function update(UpdateInseminationMethodRequest $request, InseminationMethodService $inseminationMethodService, InseminationMethod $inseminationMethod): JsonResponse
    {
        try {
            $inseminationMethod = $inseminationMethodService->updateInseminationMethod($request->validated(), $inseminationMethod);
            return ApiResponse::success([InseminationMethodResource::make($inseminationMethod)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteInseminationMethodRequest $request
     * @param InseminationMethodService $inseminationMethodService
     * @param InseminationMethod $inseminationMethod
     * @return JsonResponse
     */
    public function destroy(DeleteInseminationMethodRequest $request, InseminationMethodService $inseminationMethodService,  InseminationMethod $inseminationMethod): JsonResponse
    {
        try {
            return ApiResponse::success($inseminationMethodService->deleteInseminationMethod($inseminationMethod));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
