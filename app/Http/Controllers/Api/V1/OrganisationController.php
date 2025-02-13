<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Organisation\IndexOrganisationRequest;
use App\Http\Requests\Organisation\ShowOrganisationRequest;
use App\Http\Requests\Organisation\StoreOrganisationRequest;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Http\Requests\Organisation\DeleteOrganisationRequest;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Http\Responses\ApiResponse;
use App\Models\Organisation;
use App\Services\Organisation\OrganisationService;
use Illuminate\Http\JsonResponse;

class OrganisationController extends Controller
{
    /**
     * @param IndexOrganisationRequest $request
     * @param OrganisationService $organisationService
     * @return JsonResponse
     */
    public function index(IndexOrganisationRequest $request, OrganisationService $organisationService): JsonResponse
    {
        try {
            $organisations = $organisationService->index($request->validated());
            return ApiResponse::success(OrganisationResource::paginatedCollection($organisations));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreOrganisationRequest $request
     * @param OrganisationService $organisationService
     * @return JsonResponse
     */
    public function store(StoreOrganisationRequest $request, OrganisationService $organisationService): JsonResponse
    {
        try {
            $organisation = $organisationService->storeOrganisation($request->validated());
            return ApiResponse::success(new OrganisationResource($organisation));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * @param ShowOrganisationRequest $request
     * @param OrganisationService $service
     * @param Organisation $organisation
     * @return JsonResponse
     */
    public function show(ShowOrganisationRequest $request, OrganisationService $service, Organisation $organisation): JsonResponse
    {
        try {
            $organisation = $service->show($organisation);
            return ApiResponse::success(['organisation' => new OrganisationResource($organisation)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateOrganisationRequest $request
     * @param OrganisationService $organisationService
     * @param Organisation $organisation
     * @return JsonResponse
     */
    public function update(UpdateOrganisationRequest $request, OrganisationService $organisationService, Organisation $organisation): JsonResponse
    {
        try {

            $organisation = $organisationService->updateOrganisation($request->validated(), $organisation);
            return ApiResponse::success(['organisation' => new OrganisationResource($organisation)]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }

    /**
     * Remove the specified resource from storage.
     * @param DeleteOrganisationRequest $request
     * @param OrganisationService $service
     * @param Organisation $organisation
     * @return JsonResponse
     */
    public function destroy(DeleteOrganisationRequest $request, OrganisationService $organisationService, Organisation $organisation): JsonResponse
    {
        try {
            $organisation = $organisationService->delete($organisation);
            return ApiResponse::success($organisation);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
    }
}
