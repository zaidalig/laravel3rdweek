<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserUploadImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('users/verify/{Token}', [UserController::class, 'verifyUser'])->name('verifyemail');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
Route::get('products.search', [ProductController::class, 'search'])->name('prdocuts.search');
Route::get('categories.search',[CategoryController::class,'search'])->name('categories.search');
Route::get('users.search',[UserController::class,'search'])->name('users.search');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('gotoprofile/', [AuthController::class, 'gotoprofile'])->name('gotoprofile');
    Route::post('/edit_profile', [AuthController::class, 'edit_profile'])->name('edit_profile');
    Route::get('change_password', [AuthController::class, 'change_password'])->name('change_password');
    Route::post('check_and_update_password', [AuthController::class, 'check_and_update_password'])->name('check_and_update_password');
    Route::post('products.approve/{product}', [ProductController::class, 'approve']);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::get('gotomyimages', [UserUploadImageController::class, 'gotomyimages'])->name('gotomyimages');
    Route::get('uploadimages', [UserUploadImageController::class, 'uploadimages'])->name('uploadimages');
    Route::post('/storeimages', [UserUploadImageController::class, 'storeimages'])->name('storeimages');
    Route::resource('roles', RoleController::class);

});
