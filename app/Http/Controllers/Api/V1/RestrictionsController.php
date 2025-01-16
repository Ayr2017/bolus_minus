<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Breed\ShowBreadRequest;
use App\Http\Requests\Restriction\DeleteRestrictionRequest;
use App\Http\Requests\Restriction\IndexRestrictionRequest;
use App\Http\Requests\Restriction\ShowRestrictionRequest;
use App\Http\Requests\Restriction\StoreRestrictionRequest;
use App\Http\Requests\Restriction\UpdateRestrictionRequest;
use App\Http\Resources\Restriction\RestrictionResource;
use App\Http\Responses\ApiResponse;
use App\Models\Restriction;
use App\Services\Restriction\RestrictionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RestrictionsController extends Controller
{
    /**
     * @param IndexRestrictionRequest $request
     * @param RestrictionService $restrictionService
     * @return JsonResponse
     */
    public function index(IndexRestrictionRequest $request, RestrictionService $restrictionService): JsonResponse
    {
        try {
            $restrictions = $restrictionService->getRestrictions($request->validated());
            return ApiResponse::success(RestrictionResource::paginatedCollection($restrictions));
        }catch (\Throwable $throwable){
            ErrorLog::write(__METHOD__,__LINE__,$throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreRestrictionRequest $request
     * @param  RestrictionService $restrictionService
     * @return JsonResponse
     */
    public function store(StoreRestrictionRequest $request, RestrictionService $restrictionService): JsonResponse
    {
        try {
            $restriction = $restrictionService->storeRestriction($request->validated());

            return ApiResponse::success(new RestrictionResource($restriction));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Display the specified resource.
     * @param int $restriction
     * @param ShowBreadRequest $request
     * @param RestrictionService $service
     * @return JsonResponse
     */
    public function show(ShowRestrictionRequest $request, RestrictionService $service, int $restriction): JsonResponse
    {
        try {
            $restriction = $service->show($restriction);
            return ApiResponse::success(['restriction' => RestrictionResource::make($restriction)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateRestrictionRequest $request
     * @param int $restriction
     * @param RestrictionService $restrictionService
     * @return JsonResponse
     */
    public function update(UpdateRestrictionRequest $request, RestrictionService $restrictionService, Restriction $restriction): JsonResponse
    {
        try {
            $restriction = $restrictionService->update($request->validated(), $restriction);
            return ApiResponse::success(['restriction' => RestrictionResource::make($restriction)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteRestrictionRequest $request
     * @param int $restriction
     * @param RestrictionService $service
     * @return JsonResponse
     */
    public function destroy(DeleteRestrictionRequest $request, RestrictionService $restrictionService,  Restriction $restriction): JsonResponse
    {
        try {
            return ApiResponse::success($restrictionService->deleteRestriction($restriction));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
