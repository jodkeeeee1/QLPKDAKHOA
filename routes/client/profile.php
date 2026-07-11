<?php

use App\Http\Controllers\Client\UserController;
use App\Http\Controllers\Client\BookController;
use Illuminate\Support\Facades\Route;

Route::prefix('ho-so')->middleware('check_login_client')
    ->name('profile.')
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::patch('cap-nhat-thong-tin', [UserController::class, 'updateProfile'])->name('update');
        Route::patch('doi-mat-khau', [UserController::class, 'changePassword'])->name('change-password');
        Route::patch('doi-hinh-dai-dien', [UserController::class, 'updateAvatar'])->name('change-avatar');
        Route::get('/huy-lich/{book_id}', [BookController::class, 'cancelBooking'])->name('booking.cancel');
          Route::get(
    '/payment/momo/return',
    [UserController::class,'momoReturn']
)->name('momo.return');
 Route::patch(
            'cap-nhat-thong-tin-kham-benh',
            [UserController::class, 'updateMedicalInfo']
        )->name('updateMedicalInfo');
        Route::post(
'/invoice/payment',
[UserController::class,'payment']
)->name('invoice.payment');
    });
