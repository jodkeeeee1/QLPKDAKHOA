<?php

use App\Http\Controllers\Admin\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::prefix('schedules')
    ->middleware('check_login_admin')
    ->group(function () {

        Route::get('/', [ScheduleController::class, 'index'])
            ->name('schedules.index');

        Route::get('/data', [ScheduleController::class, 'getData'])
            ->name('schedules.data');

        Route::get('/doctor', [ScheduleController::class, 'getDoctors'])
            ->name('schedules.doctors');

        Route::post('/create', [ScheduleController::class, 'store'])
            ->name('schedules.store');

        // EDIT
        Route::get('/{id}/edit', [ScheduleController::class, 'edit'])
            ->name('schedules.edit');

        // UPDATE
        Route::patch('/{id}', [ScheduleController::class, 'update'])
            ->name('schedules.update');

        // DELETE
        Route::delete('/{id}', [ScheduleController::class, 'delete'])
            ->name('schedules.delete');
    });