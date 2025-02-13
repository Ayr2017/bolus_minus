<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\MilkingEquipment\IndexMilkingEquipmentRequest;
use App\Http\Requests\MilkingEquipment\ShowMilkingEquipmentRequest;
use App\Http\Requests\MilkingEquipment\StoreMilkingEquipmentRequest;
use App\Http\Requests\MilkingEquipment\UpdateMilkingEquipmentRequest;
use App\Http\Requests\MilkingEquipment\DeleteMilkingEquipmentRequest;
use App\Http\Resources\MilkingEquipment\MilkingEquipmentResource;
use App\Http\Responses\ApiResponse;
use App\Models\MilkingEquipment;
use App\Services\MilkingEquipment\MilkingEquipmentService;
use Illuminate\Http\JsonResponse;

class MilkingEquipmentController extends Controller
{
    /**
     * @param IndexMilkingEquipmentRequest $request
     * @param MilkingEquipmentService $milkingEquipmentService
     * @return JsonResponse
     */
    public function index(IndexMilkingEquipmentRequest $request, MilkingEquipmentService $milkingEquipmentService): JsonResponse
    {
        try {
            $milkingEquipments = $milkingEquipmentService->index($request->validated());
            return ApiResponse::success(MilkingEquipmentResource::paginatedCollection($milkingEquipments));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreMilkingEquipmentRequest $request
     * @param MilkingEquipmentService $milkingEquipmentService
     * @return JsonResponse
     */
    public function store(StoreMilkingEquipmentRequest $request, MilkingEquipmentService $milkingEquipmentService): JsonResponse
    {
        try {
            $milkingEquipment = $milkingEquipmentService->store($request->validated());
            return ApiResponse::success(new MilkingEquipmentResource($milkingEquipment));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param MilkingEquipmentService $service
     * @param MilkingEquipment $milkingEquipment
     * @return JsonResponse
     */
    public function show(MilkingEquipmentService $service, MilkingEquipment $milkingEquipment): JsonResponse
    {
        try {
            $milkingEquipment = $service->show($milkingEquipment);
            return ApiResponse::success([new MilkingEquipmentResource($milkingEquipment)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateMilkingEquipmentRequest $request
     * @param MilkingEquipmentService $milkingEquipmentService
     * @param MilkingEquipment $milkingEquipment
     * @return JsonResponse
     */
    public function update(UpdateMilkingEquipmentRequest $request, MilkingEquipmentService $milkingEquipmentService, MilkingEquipment $milkingEquipment): JsonResponse
    {
        try {
            $milkingEquipment = $milkingEquipmentService->update($request->validated(), $milkingEquipment);
            return ApiResponse::success([new MilkingEquipmentResource($milkingEquipment)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param MilkingEquipmentService $service
     * @param MilkingEquipment $milkingEquipment
     * @return JsonResponse
     */
    public function destroy(MilkingEquipmentService $milkingEquipmentService, MilkingEquipment $milkingEquipment): JsonResponse
    {
        try {
            $milkingEquipment = $milkingEquipmentService->delete($milkingEquipment);
            return ApiResponse::success($milkingEquipment);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
