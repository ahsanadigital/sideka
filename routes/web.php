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

Route::get('/', fn() => view('welcome'));

Auth::routes(['register' => false]);

Route::prefix('/panel')->middleware('auth')->group(function() {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('decree', App\Http\Controllers\DecreeController::class)->only('index');
    Route::resource('member', App\Http\Controllers\MemberController::class)->only('index');
    Route::resource('meeting', App\Http\Controllers\MeetingController::class)->only('index');
    Route::resource('achievement', App\Http\Controllers\AchievementController::class)->only('index');
    Route::resource('letter', App\Http\Controllers\LetterController::class)->only('index');
    Route::resource('council', App\Http\Controllers\CouncilController::class)->only('index');
    Route::resource('event-report', App\Http\Controllers\EventReportController::class)->only('index');
    Route::resource('event-agenda', App\Http\Controllers\EventAgendaController::class)->only('index');
});
