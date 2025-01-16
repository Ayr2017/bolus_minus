<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\AnimalGroup\IndexAnimalGroupRequest;
use App\Http\Requests\AnimalGroup\DeleteAnimalGroupRequest;
use App\Http\Requests\AnimalGroup\ShowAnimalGroupRequest;
use App\Http\Requests\AnimalGroup\StoreAnimalGroupRequest;
use App\Http\Requests\AnimalGroup\UpdateAnimalGroupRequest;
use App\Http\Resources\AnimalGroup\AnimalGroupResource;
use App\Http\Responses\ApiResponse;
use App\Models\AnimalGroup;
use App\Services\AnimalGroup\AnimalGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnimalGroupsController extends Controller
{

    /**
     * @param IndexAnimalGroupRequest $request
     * @param AnimalGroupService $animalGroupService
     * @return JsonResponse
     */
    public function index(IndexAnimalGroupRequest $request, AnimalGroupService $animalGroupService): JsonResponse
    {
        try {
            $animalGroups = $animalGroupService->getAnimalGroups($request->validated());
            return ApiResponse::success(AnimalGroupResource::paginatedCollection($animalGroups));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Store a newly created resource in storage.
     * @param StoreAnimalGroupRequest $request
     * @param  AnimalGroupService $animalGroupService
     * @return JsonResponse
     */
    public function store(StoreAnimalGroupRequest $request, AnimalGroupService $animalGroupService): JsonResponse
    {
        try {
            $animalGroup = $animalGroupService->storeAnimalGroup($request->validated());

            return ApiResponse::success(new AnimalGroupResource($animalGroup));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Display the specified resource.
     * @param AnimalGroup $animalGroup
     * @param ShowAnimalGroupRequest $request
     * @param AnimalGroupService $service
     * @return JsonResponse
     */
    public function show(ShowAnimalGroupRequest $request, AnimalGroupService $service, AnimalGroup $animalGroup): JsonResponse
    {
        try {
            $animalGroup = $service->show($animalGroup);
            return ApiResponse::success(['breed' => AnimalGroupResource::make($animalGroup)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }


    /**
     * Update the specified resource in storage.
     * @param UpdateAnimalGroupRequest $request
     * @param int $animalGroup
     * @param AnimalGroupService $animalGroupService
     * @return JsonResponse
     */
    public function update(UpdateAnimalGroupRequest $request, AnimalGroupService $animalGroupService, int $animalGroup): JsonResponse
    {
        try {
            $animalGroup = $animalGroupService->updateAnimalGroup($request->validated(), $animalGroup);

            return ApiResponse::success(['breed' => AnimalGroupResource::make($animalGroup)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteAnimalGroupRequest $request
     * @param int $animalGroup
     * @param AnimalGroupService $service
     * @return JsonResponse
     */
    public function destroy(DeleteAnimalGroupRequest $request, AnimalGroupService $animalGroupService,  int $animalGroup): JsonResponse
    {
        try {
            return ApiResponse::success($animalGroupService->deleteAnimalGroup($animalGroup));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
