<?php

use App\Http\Controllers\FormDefinitionController;
use App\Http\Controllers\FormSubmissionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('forms', FormDefinitionController::class);
    Route::get('forms/{form}/submissions', [FormSubmissionController::class, 'index'])->name('forms.submissions.index');
    Route::get('forms/{form}/submit', [FormSubmissionController::class, 'create'])->name('forms.submissions.create');
    Route::post('forms/{form}/submit', [FormSubmissionController::class, 'store'])->name('forms.submissions.store');
});
