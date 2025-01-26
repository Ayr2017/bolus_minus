<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sanctum\CreateTokenRequest;
use App\Http\Responses\ApiResponse;
use App\Services\Sanctum\SanctumService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SanctumController extends Controller
{
    /**
     * @param CreateTokenRequest $request
     * @param SanctumService $sanctumService
     * @return JsonResponse
     */
    public function createToken(CreateTokenRequest $request, SanctumService $sanctumService): JsonResponse
    {
        try {
            $token = $sanctumService->createToken($request->validated());

            return ApiResponse::success(['token' => $token]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong');
    }

    /**
     * @param CreateTokenRequest $request
     * @param SanctumService $sanctumService
     * @return JsonResponse
     */
    public function auth(CreateTokenRequest $request, SanctumService $sanctumService): JsonResponse
    {
        try {
            $token = $sanctumService->createToken($request->validated());
            if (!Auth::attempt(Arr::only($request->validated(), ['email', 'password']))) {
                throw new \Exception('Invalid credentials');
            }

            return ApiResponse::success([
                'token' => $token,
                'user' => auth('sanctum')->user()
                ]);

        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
            return ApiResponse::error([$throwable->getMessage()],$throwable->getMessage(),);
        }

    }
}
