<?php

use App\Http\Controllers\API\FileController;
use App\Http\Controllers\WEB\CareerController;
use App\Http\Controllers\WEB\ContactUsController;
use App\Http\Controllers\WEB\HomeController;
use App\Http\Controllers\WEB\PostController;
use App\Http\Controllers\WEB\TaxonamyController;
use Illuminate\Support\Facades\Route;

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

Route::get('files/{path}', [FileController::class, 'show'])->where('path', '.*')->name('ui.file.show');
Route::get('/', function () {
    return redirect(app()->getLocale());
});

Route::group([
    'prefix'     => '{locale}',
    'where'      => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'localeMiddleware',
    'as'         => 'ui.',
], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('mail-contact', [ContactUsController::class, 'execute'])->name('send_mail.contact');
    Route::post('jobs-candidates/{job}', [CareerController::class, 'store'])->name('send_mail.job');
    Route::get('search-post', [PostController::class, 'searchPost'])->name('post.search');

    // Category
    Route::get('taxonomy/{taxonomy:slug}', [TaxonamyController::class, 'show'])->name('taxonomy.show');
    Route::get('job/{job:slug}', [CareerController::class, 'show'])->name('job.show');

    Route::group(['prefix' => '{post:slug}', 'as' => 'posts.'], function () {
        Route::get('search-career', [CareerController::class, 'index'])->name('career.search');
        Route::get('category/filter', [PostController::class, 'filterPost'])->name('category.filter');
        Route::get('/', [PostController::class, 'show'])->name('post.show')->where('post', '^[a-zA-Z0-9-_\/]+$');
    });
});

Route::fallback(function () {
    return redirect('/');
});