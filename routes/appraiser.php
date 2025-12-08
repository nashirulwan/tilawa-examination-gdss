Route::middleware(['auth', 'role:appraiser'])->group(function () {
    Route::get('/assessments', [App\Http\Controllers\AssessmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/{participant}/rate', [App\Http\Controllers\AssessmentController::class, 'create'])->name('assessments.rate');
    Route::post('/assessments/{participant}', [App\Http\Controllers\AssessmentController::class, 'store'])->name('assessments.store');
});
