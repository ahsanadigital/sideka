<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', fn () => abort(503, "Sedang dalam tahap pembangunan"));
Route::get('/surat-keputusan', fn () => abort(503, "Sedang dalam tahap pembangunan"));
Route::get('/kegiatan', fn () => abort(503, "Sedang dalam tahap pembangunan"));
Route::get('/keanggotaan', fn () => abort(503, "Sedang dalam tahap pembangunan"));

Auth::routes(['register' => false]);

Route::prefix('/panel')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('council-category', App\Http\Controllers\CouncilCategoryController::class)->only('index');
    Route::resource('decree', App\Http\Controllers\DecreeController::class)->only('index');
    Route::resource('member', App\Http\Controllers\MemberController::class)->only('index');
    Route::resource('meeting', App\Http\Controllers\MeetingController::class)->only('index');
    Route::resource('achievement', App\Http\Controllers\AchievementController::class)->only('index');
    Route::resource('letter', App\Http\Controllers\LetterController::class)->only('index');
    Route::resource('council', App\Http\Controllers\CouncilController::class)->only('index');
    Route::resource('event-report', App\Http\Controllers\EventReportController::class)->only('index');
    Route::resource('event-agenda', App\Http\Controllers\EventAgendaController::class)->only('index');
    Route::resource('user', App\Http\Controllers\UserController::class)->only('index');
});

Route::controller(App\Http\Controllers\UtilsController::class)->prefix('util')->name('utils.')->group(function () {
    Route::any('download-file', 'downloadFile')->name('download-file');
});
