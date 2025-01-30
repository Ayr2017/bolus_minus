<?php

use App\Http\Controllers\Api\V1\AnimalGroupsController;
use App\Http\Controllers\Api\V1\AnimalsController;
use App\Http\Controllers\Api\V1\BreedingBullsController;
use App\Http\Controllers\Api\V1\BreedsController;
use App\Http\Controllers\Api\V1\CoatColorsController;
use App\Http\Controllers\Api\V1\HerdEntryReasonsController;
use App\Http\Controllers\Api\V1\InseminationMethodsController;
use App\Http\Controllers\Api\V1\EventsController;
use App\Http\Controllers\Api\V1\MilkingEquipmentsController;
use App\Http\Controllers\Api\V1\MilkingsController;
use App\Http\Controllers\Api\V1\OrganisationsController;
use App\Http\Controllers\Api\V1\RestrictionReasonsController;
use App\Http\Controllers\Api\V1\RestrictionsController;
use App\Http\Controllers\Api\V1\SanctumController;
use App\Http\Controllers\Api\V1\SelectedBreedingBullsController;
use App\Http\Controllers\Api\V1\SemenPortionsController;
use App\Http\Controllers\Api\V1\ShiftsController;
use App\Http\Controllers\Api\V1\StructuralUnitsController;
use App\Http\Controllers\Api\V1\TagColorsController;
use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\ZootechnicalExitReasonsController;
use Illuminate\Support\Facades\Route;


Route::post('/sanctum/token', [SanctumController::class, 'createToken']);
Route::prefix('v1')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::resource('animals', AnimalsController::class);
        Route::apiResource('users', UsersController::class);
        Route::apiResource('animal-groups', AnimalGroupsController::class);
        Route::apiResource('breeds', BreedsController::class);
        Route::apiResource('breeding-bulls', BreedingBullsController::class);
        Route::apiResource('coat-colors', CoatColorsController::class);
        Route::apiResource('events', EventsController::class);
        Route::apiResource('herd-entry-reasons', HerdEntryReasonsController::class);
        Route::apiResource('insemination-methods', InseminationMethodsController::class);
        Route::apiResource('organisations', OrganisationsController::class);
        Route::apiResource('restrictions', RestrictionsController::class);
        Route::apiResource('restriction-reasons', RestrictionReasonsController::class);
        Route::apiResource('semen-portions', SemenPortionsController::class);
        Route::apiResource('structural-units', StructuralUnitsController::class);
        Route::apiResource('tag-colors', TagColorsController::class);
        Route::get('users/get-current-user', [UsersController::class, 'getCurrentUser']);

        Route::apiResource('zootechnical-exit-reasons', ZootechnicalExitReasonsController::class);


//        Route::get('selected-breeding-bulls', [BreedingBullsController::class, 'selectedBreedingBulls']);
//        Route::get('owned-breeding-bulls', [BreedingBullsController::class, 'selectedBreedingBulls']);


        Route::group(['prefix' => 'settings'], function () {
            Route::apiResource('milking-equipments', MilkingEquipmentsController::class);
            Route::apiResource('shifts', ShiftsController::class);
            Route::apiResource('milkings', MilkingsController::class);
        });


    });

Route::prefix('v1')
    ->middleware(['api'])
    ->group(function () {
        Route::post('/auth', [SanctumController::class,'auth'])->name('auth');
    });


