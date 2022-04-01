<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\FormController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');
    Route::resource('/forms',FormController::class);
});

Route::get('/public-form/{form:slug}',[FormController::class,'showBySlug'])->name('showBySlug');
Route::post('/form/{form}/answer',[FormController::class,'saveFormAnswer'])->name('saveFormAnswer');
Route::post('/register',[AuthController::class,'register'])->name('register');
Route::post('/login',[AuthController::class,'login'])->name('login');

