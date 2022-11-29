<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis\ApiAuthController;
use App\Http\Controllers\Apis\ApiUserController;
use App\Http\Controllers\Apis\ApiProductController;
use App\Http\Controllers\Apis\ApiCategoryController;
use App\Http\Controllers\Apis\ApiRoleController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['middleware' => ['cors', 'json.response']], function () {

    // ...

    // public routes
    Route::post('/login', [ApiAuthController::class,'login'])->name('login.api');
    Route::post('/register',[ApiAuthController::class,'register'])->name('register.api');
    Route::post('/submitForgetPasswordForm', [ApiAuthController::class,'submitForgetPasswordForm'])->
    name('submitForgetPasswordForm.api');
    Route::post('/submitResetPasswordForm', [ApiAuthController::class,'submitResetPasswordForm'])->
    name('submitResetPasswordForm.api');
    // ...

});

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [ApiAuthController::class,'logout'])->name('logout.api');
    Route::post('/edit_profile', [ApiAuthController::class,'edit_profile'])->name('edit_profile.api');
    Route::post('/check_and_update_password', [ApiAuthController::class,'check_and_update_password'])->
    name('check_and_update_password.api');
    Route::apiResource('user', ApiUserController::class);
    Route::apiResource('product', ApiProductController::class);
    Route::apiResource('category', ApiCategoryController::class);
    Route::apiResource('role', ApiRoleController::class);

    Route::post('products.search', [ApiProductController::class, 'search'])->name('prodcuts.search.api');
    Route::post('users.search',[ApiUserController::class,'search'])->name('users.search.api');
    Route::post('category.search',[ApiCategoryController::class,'search'])->name('category.search.api');




});



