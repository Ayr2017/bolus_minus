<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Animal\GetAnimalsRequest;
use App\Http\Requests\Animal\ShowAnimalRequest;
use App\Http\Resources\Animal\AnimalResource;
use App\Http\Responses\ApiResponse;
use App\Models\Animal;
use App\Services\Animal\AnimalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnimalsController extends Controller
{
    public function __construct(readonly AnimalService $animalService) {}

    /**
     * @param GetAnimalsRequest $request
     * @return JsonResponse
     */
    public function index(GetAnimalsRequest $request): JsonResponse
    {
        try {
            $animals = $this->animalService->getAnimals($request->validated());
            return ApiResponse::success(AnimalResource::paginatedCollection($animals));
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
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
    public function show(ShowAnimalRequest $request, int $animal): JsonResponse
    {
        try {
            return ApiResponse::success(['animal' => AnimalResource::make(Animal::query()->find($animal))]);
        } catch (\Throwable $throwable) {
            ErrorLog::write(__METHOD__, __LINE__, $throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
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
