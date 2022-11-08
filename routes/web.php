<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth');
Route::get('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('gotoprofile/', [AuthController::class, 'gotoprofile'])->name('gotoprofile')->middleware('auth');
Route::post('/edit_profile', [AuthController::class, 'edit_profile'])->name('edit_profile')->middleware('auth');
Route::get('change_password', [AuthController::class, 'change_password'])->name('change_password');
Route::post('check_and_update_password', [AuthController::class, 'check_and_update_password'])->name('check_and_update_password');
