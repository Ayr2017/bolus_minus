<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetCurrentUserRequest;
use App\Http\Requests\User\SearchUsersRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{
    public function __construct(readonly UserService $userService) {}

    /**
     * @param SearchUsersRequest
     * @return JsonResponse
     */
    public function index(SearchUsersRequest $request): JsonResponse
    {
        try {
            $data = $this->userService->search($request->validated());
            return ApiResponse::success(UserResource::paginatedCollection($data));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong');
    }

    /**
     * @param StoreUserRequest
     * @param UserService $userService
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request, UserService $userService)
    {
        try {
            $user = $userService->store($request->validated());
            return ApiResponse::success(new UserResource($user));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
            Log::error(__METHOD__ . ' - Exception: ' . $throwable->getMessage(), ['trace' => $throwable->getTraceAsString()]);
        }
        return ApiResponse::error('Something went wrong');
    }

    /**
     * @return JsonResponse
     */
    public function show(User $user)
    {
        $data = UserResource::make($user);
        return ApiResponse::success($data);
    }

    /**
     * @param UpdateUserRequest
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $result = $this->userService->update($user, $request->validated());
            if ($result) {
                return ApiResponse::success(UserResource::make($user->fresh()));
            }
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
            return ApiResponse::error($throwable->getMessage());
        }
        return ApiResponse::error('Something went wrong');
    }

    /**
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return ApiResponse::success($user);
    }

    /**
     * @param GetCurrentUserRequest
     * @return JsonResponse
     */
    public function getCurrentUser(GetCurrentUserRequest $request): JsonResponse
    {
        try {
            $currentUser = auth()->user()->load(['employees.organisation']);
            return ApiResponse::success(UserResource::make($currentUser));
        } catch (\Throwable $throwable) {
            ErrorLog::write(method: __METHOD__, line: __LINE__, errorMessage: $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong');
    }
}
