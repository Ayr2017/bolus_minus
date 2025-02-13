<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Bolus\IndexBolusRequest;
use App\Http\Requests\Bolus\ShowBolusRequest;
use App\Http\Requests\Bolus\StoreBolusRequest;
use App\Http\Requests\Bolus\UpdateBolusRequest;
use App\Http\Requests\Bolus\DeleteBolusRequest;
use App\Http\Resources\Bolus\BolusResource;
use App\Http\Responses\ApiResponse;
use App\Models\Bolus;
use App\Services\Bolus\BolusService;
use Illuminate\Http\JsonResponse;

class BolusController extends Controller
{
    /**
     * @param IndexBolusRequest $request
     * @param BolusService $bolusService
     * @return JsonResponse
     */
    public function index(IndexBolusRequest $request, BolusService $bolusService): JsonResponse
    {
        try {
            $boluses = $bolusService->index($request->validated());
            return ApiResponse::success(BolusResource::collection($boluses));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreBolusRequest $request
     * @param BolusService $bolusService
     * @return JsonResponse
     */
    public function store(StoreBolusRequest $request, BolusService $bolusService): JsonResponse
    {
        try {
            $bolus = $bolusService->store($request->validated());
            return ApiResponse::success(new BolusResource($bolus));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowBolusRequest $request
     * @param BolusService $service
     * @param Bolus $bolus
     * @return JsonResponse
     */
    public function show(ShowBolusRequest $request, BolusService $service, Bolus $bolus): JsonResponse
    {
        try {
            $bolus = $service->show($bolus);
            return ApiResponse::success(['bolus' => new BolusResource($bolus)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateBolusRequest $request
     * @param BolusService $bolusService
     * @param Bolus $bolus
     * @return JsonResponse
     */
    public function update(UpdateBolusRequest $request, BolusService $bolusService, Bolus $bolus): JsonResponse
    {
        try {
            $bolus = $bolusService->update($request->validated(), $bolus);
            return ApiResponse::success(['bolus' => new BolusResource($bolus)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteBolusRequest $request
     * @param BolusService $service
     * @param Bolus $bolus
     * @return JsonResponse
     */
    public function destroy(DeleteBolusRequest $request, BolusService $bolusService, Bolus $bolus): JsonResponse
    {
        try {
            $bolus = $bolusService->delete($bolus);
            return ApiResponse::success($bolus);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
