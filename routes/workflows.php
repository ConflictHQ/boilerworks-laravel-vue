<?php

use App\Http\Controllers\WorkflowDefinitionController;
use App\Http\Controllers\WorkflowInstanceController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('workflows', WorkflowDefinitionController::class);
    Route::get('workflows/{workflow}/instances', [WorkflowInstanceController::class, 'index'])->name('workflows.instances.index');
    Route::post('workflows/{workflow}/instances', [WorkflowInstanceController::class, 'store'])->name('workflows.instances.store');
    Route::post('workflows/{workflow}/instances/{instance}/transition', [WorkflowInstanceController::class, 'transition'])->name('workflows.instances.transition');
});
