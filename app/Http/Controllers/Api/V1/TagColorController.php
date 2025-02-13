<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagColor\IndexTagColorRequest;
use App\Http\Resources\TagColor\TagColorResource;
use App\Http\Responses\ApiResponse;
use App\Services\TagColor\TagColorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagColorController extends Controller
{
    public function __construct(readonly TagColorService $tagColorService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(IndexTagColorRequest $request): JsonResponse
    {
        try {
            $data = $this->tagColorService->getTagColors($request->validated());
            return ApiResponse::success(TagColorResource::paginatedCollection($data));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
