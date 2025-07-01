<?php

use App\Http\Controllers\ExcelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExcelController::class, 'form'])->name('excel.form');
Route::post('/upload', [ExcelController::class, 'upload'])->name('excel.upload');
