<?php

use App\Http\Controllers\Api\V1\AnimalGroupController;
use App\Http\Controllers\Api\V1\AnimalController;
use App\Http\Controllers\Api\V1\BolusController;
use App\Http\Controllers\Api\V1\BreedingBullController;
use App\Http\Controllers\Api\V1\BreedController;
use App\Http\Controllers\Api\V1\CoatColorController;
use App\Http\Controllers\Api\V1\HerdEntryReasonController;
use App\Http\Controllers\Api\V1\InseminationMethodController;
use App\Http\Controllers\Api\V1\EventController;
use App\Http\Controllers\Api\V1\MilkingEquipmentController;
use App\Http\Controllers\Api\V1\MilkingController;
use App\Http\Controllers\Api\V1\OrganisationController;
use App\Http\Controllers\Api\V1\RestrictionReasonController;
use App\Http\Controllers\Api\V1\RestrictionController;
use App\Http\Controllers\Api\V1\SanctumController;
use App\Http\Controllers\Api\V1\SemenPortionController;
use App\Http\Controllers\Api\V1\ShiftController;
use App\Http\Controllers\Api\V1\StatusController;
use App\Http\Controllers\Api\V1\StructuralUnitController;
use App\Http\Controllers\Api\V1\TagColorController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\ZootechnicalExitReasonController;
use Illuminate\Support\Facades\Route;


Route::post('/sanctum/token', [SanctumController::class, 'createToken']);
Route::prefix('v1')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::apiResource('animals', AnimalController::class);
        Route::apiResource('animal-groups', AnimalGroupController::class);
        Route::apiResource('boluses', BolusController::class);
        Route::apiResource('breeds', BreedController::class);
        Route::apiResource('breeding-bulls', BreedingBullController::class);
        Route::apiResource('coat-colors', CoatColorController::class);
        Route::apiResource('events', EventController::class);
        Route::apiResource('herd-entry-reasons', HerdEntryReasonController::class);
        Route::apiResource('insemination-methods', InseminationMethodController::class);
        Route::apiResource('organisations', OrganisationController::class);
        Route::apiResource('restrictions', RestrictionController::class);
        Route::apiResource('restriction-reasons', RestrictionReasonController::class);
        Route::apiResource('semen-portions', SemenPortionController::class);
        Route::apiResource('statuses', StatusController::class);
        Route::apiResource('structural-units', StructuralUnitController::class);
        Route::apiResource('tag-colors', TagColorController::class);
        Route::get('users/get-current-user', [UserController::class, 'getCurrentUser']);
        Route::apiResource('users', UserController::class);
        Route::apiResource('zootechnical-exit-reasons', ZootechnicalExitReasonController::class);

        Route::group(['prefix' => 'settings'], function () {
            Route::apiResource('milking-equipments', MilkingEquipmentController::class);
            Route::apiResource('shifts', ShiftController::class);
            Route::apiResource('milkings', MilkingController::class);
        });
    });

Route::prefix('v1')
    ->middleware(['api'])
    ->group(function () {
        Route::post('/auth', [SanctumController::class, 'auth'])->name('auth');
    });
