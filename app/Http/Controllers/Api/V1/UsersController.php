<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\GetCurrentUserRequest;
use App\Http\Requests\User\SearchUsersRequest;
use App\Http\Requests\User\StoreRequest;
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
     * Display a listing of the resource.
     */
    public function index(SearchUsersRequest $request): JsonResponse
    {
        try {
            $data = $this->userService->search($request->validated());
            return ApiResponse::success($data);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try{
            $data = $request->validated();
            $user = User::create($data);
            return ApiResponse::success(new UserResource($user));
        }catch (\Throwable $throwable){
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }
        return ApiResponse::error('Something went wrong');

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return UserResource::make($user)->resolve();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            UserService::update($data, $user);
            return ApiResponse::success(new UserResource($user));
        }catch (\Throwable $throwable){
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }
        return ApiResponse::error('Something went wrong');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
         $user->delete();
        return ApiResponse::success($user);
    }

    public function getCurrentUser(GetCurrentUserRequest $request): JsonResponse
    {
        try {
            $currentUser = auth()->user();
            return ApiResponse::success(UserResource::make($currentUser));
        } catch (\Throwable $throwable) {
            ErrorLog::write(method: __METHOD__, line: __LINE__, errorMessage: $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong');
    }
}
