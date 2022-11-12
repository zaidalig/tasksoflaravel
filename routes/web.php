<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserUploadImageController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class);
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('gotoprofile/', [AuthController::class, 'gotoprofile'])->name('gotoprofile')->middleware('auth');
Route::post('/edit_profile', [AuthController::class, 'edit_profile'])->name('edit_profile')->middleware('auth');
Route::get('change_password', [AuthController::class, 'change_password'])->name('change_password');
Route::post('check_and_update_password', [AuthController::class, 'check_and_update_password'])->name('check_and_update_password');

Route::get('gotomyimages', [UserUploadImageController::class, 'gotomyimages'])->name('gotomyimages');
Route::get('uploadimages', [UserUploadImageController::class, 'uploadimages'])->name('uploadimages');

Route::post('/storeimages', [UserUploadImageController::class, 'storeimages'])->name('storeimages');
