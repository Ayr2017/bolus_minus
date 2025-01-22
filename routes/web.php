<?php

use App\Http\Controllers\AnimalsController;
use App\Http\Controllers\BolusesController;
use App\Http\Controllers\BolusReadingsController;
use App\Http\Controllers\BreedsController;
use App\Http\Controllers\DashboardsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\EmployeesController as AdminEmployeesController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventTypesController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\OrganisationsController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('/home');
});

Auth::routes();

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth:web'], function () {
    Route::patch('bolus-readings/pull', [BolusReadingsController::class, 'pull'])->name('bolus-readings.pull');

    Route::resource('users', UsersController::class);
    Route::resource('animals', AnimalsController::class);
    Route::resource('boluses', BolusesController::class);
    Route::resource('bolus-readings', BolusReadingsController::class);
    Route::resource('dashboards', DashboardsController::class);
    Route::resource('employees', EmployeesController::class);
    Route::resource('events', EventsController::class);
    Route::resource('fields', FieldsController::class);
    Route::resource('breeds', BreedsController::class);
    Route::resource('statuses', BreedsController::class);
    Route::resource('statuses', StatusesController::class);
    Route::resource('roles', RolesController::class);
    Route::resource('employees', AdminEmployeesController::class);
    Route::resource('organisations', OrganisationsController::class);
    Route::resource('permissions', PermissionsController::class);
    Route::resource('event-types', EventTypesController::class);

    Route::patch('employees/{employee}/permissions', [EmployeesController::class, 'updatePermissions'])->name('employees.permissions.update');
    Route::patch('users/{user}/update-roles', [UsersController::class, 'updateRoles'])->name('users.update-roles');

    Route::get('/test',function(){
        (new \App\Domains\Telegram\TelegramBot())->sendMessage('Hi');
    });
});
