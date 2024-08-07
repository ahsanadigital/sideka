<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('decree', App\Http\Controllers\DecreeController::class)->names(['index' => 'api.decree.index']);
Route::apiResource('user', App\Http\Controllers\UserController::class)->names(['index' => 'api.user.index']);
Route::apiResource('council-category', App\Http\Controllers\CouncilCategoryController::class)->names(['index' => 'api.council-category.index']);
Route::apiResource('meeting', App\Http\Controllers\MeetingController::class)->names(['index' => 'api.meeting.index']);
Route::apiResource('achievement', App\Http\Controllers\AchievementController::class)->names(['index' => 'api.achievement.index']);

Route::delete('media/removal/{media}', App\Http\Controllers\MediaRemovalController::class)->name('api.media.remove');

Route::prefix('miscellaneous')->group(function() {
    Route::get('download-file', [App\Http\Controllers\UtilsController::class, 'downloadFile'])->name('download-file');
    Route::any('search-data', [App\Http\Controllers\UtilsController::class, 'searchData'])->name('search');
});
