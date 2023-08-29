<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SampleDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\DistrictController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\UniversityController;


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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Sample API route
Route::get('/profits', [SampleDataController::class, 'profits'])->name('profits');

Route::post('/register', [RegisteredUserController::class, 'apiStore']);

Route::post('/login', [AuthenticatedSessionController::class, 'apiStore']);

Route::post('/forgot_password', [PasswordResetLinkController::class, 'apiStore']);

Route::post('/verify_token', [AuthenticatedSessionController::class, 'apiVerifyToken']);

Route::get('/users', [SampleDataController::class, 'getUsers']);


Route::middleware(['cors'])->group(function () {

    // AUTH
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/studentRegister', [AuthController::class, 'studentRegister'])->name('studentRegister');
    Route::post('/teacherRegister', [AuthController::class, 'teacherRegister'])->name('teacherRegister');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/update', [AuthController::class, 'update']);
    Route::post('/update-user-info', [AuthController::class, 'updateUserInfo']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);

    // CITY
    Route::get('cities', [CityController::class, 'index']);
    Route::get('city/{city_id}/districts', [DistrictController::class, 'districtsByCity']);

    // UNIVERSITY
    Route::get('universities', [UniversityController::class, 'index']);
    Route::get('university/{university_id}/departments', [DepartmentController::class, 'departmentsByUniversity']);
});
