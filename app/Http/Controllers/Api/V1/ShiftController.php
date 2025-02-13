<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shift\IndexShiftRequest;
use App\Http\Requests\Shift\ShowShiftRequest;
use App\Http\Requests\Shift\StoreShiftRequest;
use App\Http\Requests\Shift\UpdateShiftRequest;
use App\Http\Requests\Shift\DeleteShiftRequest;
use App\Http\Resources\Shift\ShiftResource;
use App\Http\Responses\ApiResponse;
use App\Models\Shift;
use App\Services\Shift\ShiftService;
use Illuminate\Http\JsonResponse;

class ShiftController extends Controller
{
    /**
     * @param IndexShiftRequest $request
     * @param ShiftService $shiftService
     * @return JsonResponse
     */
    public function index(IndexShiftRequest $request, ShiftService $shiftService): JsonResponse
    {
        try {
            $shifts = $shiftService->index($request->validated());
            return ApiResponse::success(ShiftResource::paginatedCollection($shifts));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreShiftRequest $request
     * @param ShiftService $shiftService
     * @return JsonResponse
     */
    public function store(StoreShiftRequest $request, ShiftService $shiftService): JsonResponse
    {
        try {
            $shift = $shiftService->store($request->validated());
            return ApiResponse::success(new ShiftResource($shift));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowShiftRequest $request
     * @param ShiftService $service
     * @param Shift $shift
     * @return JsonResponse
     */
    public function show(ShiftService $service, Shift $shift): JsonResponse
    {
        try {
            $shift = $service->show($shift);
            return ApiResponse::success([new ShiftResource($shift)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateShiftRequest $request
     * @param ShiftService $shiftService
     * @param Shift $shift
     * @return JsonResponse
     */
    public function update(UpdateShiftRequest $request, ShiftService $shiftService, Shift $shift): JsonResponse
    {
        try {
            $shift = $shiftService->update($request->validated(), $shift);
            return ApiResponse::success([new ShiftResource($shift)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteShiftRequest $request
     * @param ShiftService $service
     * @param Shift $shift
     * @return JsonResponse
     */
    public function destroy(DeleteShiftRequest $request, ShiftService $shiftService, Shift $shift): JsonResponse
    {
        try {
            $shift = $shiftService->delete($shift);
            return ApiResponse::success($shift);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
