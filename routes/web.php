<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

Route::any('/login', [AuthController::class, 'login'])->name('login');
Route::get('/forgot-password', [AuthController::class, 'requestForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'resetForm'])->name('password.reset');

Route::middleware('auth')->group(function() {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', [ExcelController::class, 'form'])->name('excel.form');
    Route::post('/upload', [ExcelController::class, 'upload'])->name('excel.upload');
    Route::get('/download', [ExcelController::class, 'getCleaned'])->name('excel.cleaning');
    Route::post('/download', [ExcelController::class, 'download'])->name('excel.download');

});
