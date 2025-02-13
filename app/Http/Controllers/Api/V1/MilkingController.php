<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Milking\IndexMilkingRequest;
use App\Http\Requests\Milking\ShowMilkingRequest;
use App\Http\Requests\Milking\StoreMilkingRequest;
use App\Http\Requests\Milking\UpdateMilkingRequest;
use App\Http\Requests\Milking\DeleteMilkingRequest;
use App\Http\Resources\Milking\MilkingResource;
use App\Http\Responses\ApiResponse;
use App\Models\Milking;
use App\Services\Milking\MilkingService;
use Illuminate\Http\JsonResponse;

class MilkingController extends Controller
{
    /**
     * @param IndexMilkingRequest $request
     * @param MilkingService $milkingService
     * @return JsonResponse
     */
    public function index(IndexMilkingRequest $request, MilkingService $milkingService): JsonResponse
    {
        try {
            $milkings = $milkingService->index($request->validated());
            return ApiResponse::success(MilkingResource::paginatedCollection($milkings));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreMilkingRequest $request
     * @param MilkingService $milkingService
     * @return JsonResponse
     */
    public function store(StoreMilkingRequest $request, MilkingService $milkingService): JsonResponse
    {
        try {
            $milking = $milkingService->store($request->validated());
            return ApiResponse::success(new MilkingResource($milking));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowMilkingRequest $request
     * @param MilkingService $service
     * @param Milking $milking
     * @return JsonResponse
     */
    public function show(ShowMilkingRequest $request, MilkingService $service, Milking $milking): JsonResponse
    {
        try {
            $milking = $service->show($milking);
            return ApiResponse::success(['milking' => new MilkingResource($milking)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateMilkingRequest $request
     * @param MilkingService $milkingService
     * @param Milking $milking
     * @return JsonResponse
     */
    public function update(UpdateMilkingRequest $request, MilkingService $milkingService, Milking $milking): JsonResponse
    {
        try {
            $milking = $milkingService->update($request->validated(), $milking);
            return ApiResponse::success(['milking' => new MilkingResource($milking)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteMilkingRequest $request
     * @param MilkingService $service
     * @param Milking $milking
     * @return JsonResponse
     */
    public function destroy(DeleteMilkingRequest $request, MilkingService $milkingService, Milking $milking): JsonResponse
    {
        try {
            $milking = $milkingService->delete($milking);
            return ApiResponse::success($milking);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
