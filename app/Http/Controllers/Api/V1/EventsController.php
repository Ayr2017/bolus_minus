<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\ErrorLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Event\IndexEventRequest;
use App\Http\Resources\Event\EventResource;
use App\Http\Resources\Restriction\RestrictionResource;
use App\Http\Responses\ApiResponse;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexEventRequest $request, EventService $eventService): JsonResponse
    {
        try {
            $result = $eventService->index($request->validated());
            if($result){
                return ApiResponse::success(EventResource::paginatedCollection($result));
            }
        }catch(\Throwable $throwable){
            ErrorLog::write(__METHOD__,__LINE__,$throwable->getMessage());
        }

        return ApiResponse::error('Something went wrong!');
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
    public function show(string $id): JsonResponse
    {
        try {
            $event = Event::findOrFail($id);
            if($event){
                return ApiResponse::success(EventResource::make($event));
            }
        }catch(\Throwable $throwable){
            ErrorLog::write(__METHOD__,__LINE__,$throwable->getMessage());
        }

        return ApiResponse::error('Event not found!');
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
