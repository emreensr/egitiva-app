<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\Logs\AuditLogsController;
use App\Http\Controllers\Logs\SystemLogsController;
use App\Http\Controllers\Account\SettingsController;
use App\Http\Controllers\Auth\SocialiteLoginController;
use App\Http\Controllers\CourseLevelController;
use App\Http\Controllers\Documentation\ReferencesController;
use App\Http\Controllers\Documentation\LayoutBuilderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect('index');
// });

$menu = theme()->getMenu();
array_walk($menu, function ($val) {
    if (isset($val['path'])) {
        $route = Route::get($val['path'], [PagesController::class, 'index']);

        // Exclude documentation from auth middleware
        if (!Str::contains($val['path'], 'documentation')) {
            $route->middleware('auth');
        }

        // Custom page demo for 500 server error
        if (Str::contains($val['path'], 'error-500')) {
            Route::get($val['path'], function () {
                abort(500, 'Something went wrong! Please try again later.');
            });
        }
    }
});

// Documentations pages
Route::prefix('documentation')->group(function () {
    Route::get('getting-started/references', [ReferencesController::class, 'index']);
    Route::get('getting-started/changelog', [PagesController::class, 'index']);
    Route::resource('layout-builder', LayoutBuilderController::class)->only(['store']);
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth')->group(function () {
        // Account pages
        Route::prefix('account')->group(function () {
            Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
            Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
            Route::put('settings/email', [SettingsController::class, 'changeEmail'])->name('settings.changeEmail');
            Route::put('settings/password', [SettingsController::class, 'changePassword'])->name('settings.changePassword');
        });

        // CATEGORIES
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('add-categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('edit-category/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('update-category/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('delete-category/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

        // SUBCATEGORİES
        Route::get('sub-categories', [SubCategoryController::class, 'index'])->name('subCategories.index');
        Route::get('sub-categories/{category_id}', [SubCategoryController::class, 'get'])->name('getSubCategories.get');
        Route::post('add-sub-categories', [SubCategoryController::class, 'store'])->name('subCategories.store');
        Route::get('edit-sub-categories/{id}', [SubCategoryController::class, 'edit'])->name('subCategories.edit');
        Route::post('update-sub-categories/{id}', [SubCategoryController::class, 'update'])->name('subCategories.update');
        Route::delete('delete-sub-categories/{id}', [SubCategoryController::class, 'delete'])->name('subCategories.delete');


        // COURSE LEVEL
        Route::get('course-levels', [CourseLevelController::class, 'index'])->name('courseLevel.index');
        Route::get('course-levels/{category_id}', [CourseLevelController::class, 'get'])->name('getCourseLevels.get');
        Route::post('add-course-levels', [CourseLevelController::class, 'store'])->name('courseLevel.store');
        Route::get('edit-course-levels/{id}', [CourseLevelController::class, 'edit'])->name('courseLevel.edit');
        Route::post('update-course-levels/{id}', [CourseLevelController::class, 'update'])->name('courseLevel.update');
        Route::delete('delete-course-levels/{id}', [CourseLevelController::class, 'delete'])->name('courseLevel.delete');


        // Logs pages
        Route::prefix('log')->name('log.')->group(function () {
            Route::resource('system', SystemLogsController::class)->only(['index', 'destroy']);
            Route::resource('audit', AuditLogsController::class)->only(['index', 'destroy']);
        });
    });
});

Route::resource('users', UsersController::class);

/**
 * Socialite login using Google service
 * https://laravel.com/docs/8.x/socialite
 */
Route::get('/auth/redirect/{provider}', [SocialiteLoginController::class, 'redirect']);

require __DIR__ . '/auth.php';
