<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ReportsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');

    // Committee Routes
    Route::resource('users', UserController::class);
    Route::resource('participants', ParticipantController::class);
    Route::resource('criteria', CriteriaController::class);
    
    Route::get('/reports/{participant}', [ReportsController::class, 'show'])->name('reports.show');

    // Appraiser Routes
    Route::get('/assessments', [App\Http\Controllers\AssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/{participant}/rate', [App\Http\Controllers\AssessmentController::class, 'create'])->name('assessments.rate');
    Route::post('/assessments/{participant}', [App\Http\Controllers\AssessmentController::class, 'store'])->name('assessments.store');
    Route::get('/my-profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');

    // Jury Chair Routes
    Route::get('/jury-chair', [App\Http\Controllers\JuryChairController::class, 'index'])->name('jury-chair.index');
    Route::post('/jury-chair/calculate', [App\Http\Controllers\JuryChairController::class, 'calculate'])->name('jury-chair.calculate');
});
