<?php

use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\AttachFilesModelController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\CompanyTourController;
use App\Http\Controllers\API\CompanyTourUserController;
use App\Http\Controllers\API\ContactUsController;
use App\Http\Controllers\API\ExcelDownloadController;
use App\Http\Controllers\API\FileController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\JobTaxonomiesController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\MailHistoryController;
use App\Http\Controllers\API\MailTemplateController;
use App\Http\Controllers\API\MajorController;
use App\Http\Controllers\API\MenuController;
use App\Http\Controllers\API\MenuLinkController;
use App\Http\Controllers\API\PermissionController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\PostTaxonomiesController;
use App\Http\Controllers\API\PostTypeController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SettingController;
use App\Http\Controllers\API\TaxonomyController;
use App\Http\Controllers\API\TemplateController;
use App\Http\Controllers\API\USER\VisitorController as UserVisitor;
use App\Http\Controllers\API\VisitorController;
use App\Http\Controllers\API\VisitorFileSettingController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('admin.login');
    Route::middleware('auth:admins')->group(function () {
        Route::delete('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('profile', [AuthController::class, 'me'])->name('admin.me');
        Route::put('profile', [AuthController::class, 'update'])->name('admin.me_update');
    });
});

Route::middleware('auth:admins')->group(function () {
    Route::apiResource('admins', AdminController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('permissions', PermissionController::class);
    //Route::apiResource('menus', MenuController::class);
    Route::apiResource('posts.taxonomies', PostTaxonomiesController::class)->only(['store', 'delete']);
    Route::apiResource('jobs.taxonomies', JobTaxonomiesController::class)->only(['store', 'delete']);

    //file
    Route::match(['PUT', 'PATCH', 'POST'], 'files/upload', [FileController::class, 'upload']);
    Route::get('files', [FileController::class, 'index']);
    Route::delete('files/{file}', [FileController::class, 'destroy']);

    Route::match(['POST', 'PUT', 'PATCH'], 'attach-file/{modelId}/{modelType}',
        [AttachFilesModelController::class, 'store']);

    Route::get('setting', [SettingController::class, 'index']);
    Route::post('setting', [SettingController::class, 'store']);

    Route::get('post-type', [PostTypeController::class, 'index']);

    Route::get('template', [TemplateController::class, 'index']);

    Route::apiResource('location', LocationController::class);

    Route::apiResource('mail-histories', MailHistoryController::class)->only(['index', 'show']);

    Route::get('list-company-tours', [CompanyTourController::class, 'listCompanyTour']);
    Route::match(['PUT', 'PATCH', 'POST'], 'update-company-tours', [CompanyTourController::class, 'updateCompanyTour']);
    Route::apiResource('company-tours', CompanyTourController::class)->except('update');

    Route::apiResource('visitors', VisitorController::class);
    Route::put('update-visitors', [VisitorController::class, 'updateStatus']);

    Route::apiResource('visitor-file-setting', VisitorFileSettingController::class)->except('store');

    Route::apiResource('contacts', ContactUsController::class);

    Route::middleware('localeCMS')->group(function () {
        Route::put('menu-links/nested', [MenuLinkController::class, 'nestedMenuLink']);
        Route::apiResource('menu-links', MenuLinkController::class);
        Route::apiResource('taxonomies', TaxonomyController::class);
        Route::apiResource('posts', PostController::class);
        Route::apiResource('jobs', JobController::class);
        Route::apiResource('banners', BannerController::class);
        Route::apiResource('menus', MenuController::class);
        Route::apiResource('mail-templates', MailTemplateController::class);
        Route::get('mail-parameters', [MailTemplateController::class, 'getParameters']);
    });
});

Route::prefix('excel-download')->group(function () {
    Route::get('visitors', [ExcelDownloadController::class, 'visitorDownload']);
    Route::get('company-tours', [ExcelDownloadController::class, 'companyTourDownload']);
});

Route::get('files/{file}/download', [FileController::class, 'download']);

Route::post('reset-password', [ResetPasswordController::class, 'sendMail']);
Route::put('reset-password/{token}', [ResetPasswordController::class, 'resetPassword'])->name('reset-password.token');

Route::prefix('user')->group(function () {
    Route::get('company-tours', [CompanyTourUserController::class, 'index']);
    Route::get('company-visit-content/{location_id}', [CompanyTourUserController::class, 'locationContent']);
    Route::post('visitors', [UserVisitor::class, 'store']);
});

Route::get('majors', [MajorController::class, 'index']);