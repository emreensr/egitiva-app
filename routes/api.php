<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CityController;
use App\Http\Controllers\SampleDataController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DistrictController;
use App\Http\Controllers\API\DepartmentController;
use App\Http\Controllers\API\UniversityController;
use App\Http\Controllers\API\CourseLevelController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\CourseRequestController;
use App\Http\Controllers\API\CourseLocationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


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
    Route::post('/update-student-info', [AuthController::class, 'updateStudentInfo']);
    Route::post('/update-student-image', [AuthController::class, 'updateImage']);
    Route::post('/update-teacher-info', [AuthController::class, 'updateTeacherInfo']);
    Route::post('/update-teacher-introduce-info', [AuthController::class, 'updateTeacherIntroduceInfo']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/get-user-details', [AuthController::class, 'getUserDetails']);

    // CITY
    Route::get('cities', [CityController::class, 'index']);
    Route::get('city/{city_id}/districts', [DistrictController::class, 'districtsByCity']);

    // UNIVERSITY
    Route::get('universities', [UniversityController::class, 'index']);
    Route::get('university/{university_id}/departments', [DepartmentController::class, 'departmentsByUniversity']);

    // CATEGORY
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('category/{category_id}/sub_categories', [SubCategoryController::class, 'subCategoriesByCategory']);
    Route::get('category/{category_id}/levels', [CourseLevelController::class, 'levelsByCategory']);

    // COURSE LOCATION
    Route::get('course-locations', [CourseLocationController::class, 'index']);

    // COURSE REQUESTS
    Route::get('course-requests', [CourseRequestController::class, 'index']);
});
