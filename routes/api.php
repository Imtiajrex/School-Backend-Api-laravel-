<?php

use App\Http\Controllers\API\V1\ReligionController;
use App\Http\Controllers\API\V1\SchoolClassController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\UserController;
use App\Http\Controllers\API\V1\DepartmentController;
use App\Http\Controllers\API\V1\GpaController;
use App\Http\Controllers\API\V1\GradeController;
use App\Http\Controllers\API\V1\InstituteInfoController;
use App\Http\Controllers\API\V1\PaymentCategoryController;
use App\Http\Controllers\API\V1\SubjectController;
use App\Http\Controllers\API\V1\PermissionController;
use App\Http\Controllers\API\V1\RoleController;
use App\Http\Controllers\API\V1\SessionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [UserController::class, 'login']);

Route::middleware("auth:sanctum")->group(function () {
    Route::get('logout', [UserController::class, 'logout']);

    Route::prefix('settings')->group(function () {

        Route::resource('user', UserController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('class', SchoolClassController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('department', DepartmentController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('gpa', GpaController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('grade', GradeController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('institute_info', InstituteInfoController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('payment_category', PaymentCategoryController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('religion', ReligionController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('subject', SubjectController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('session', SessionController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::resource('role', RoleController::class)->only([
            'index', 'store', 'update', 'destroy'
        ]);
        Route::get('permission', [PermissionController::class, "index"]);
    });
});
