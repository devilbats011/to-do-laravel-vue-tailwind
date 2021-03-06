<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkToDoCount;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\UserController;

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

Route::post('/login', [AuthApiController::class, 'login'])->name('auth.login');

Route::post('/register', [AuthApiController::class, 'register'])->name('auth.register');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/todos', TodoController::class)->only((['update','destroy','index']));
    Route::get('/user', [AuthApiController::class, 'getTheUser'])->name('auth.user');
    Route::get('/go-premium', [UserController::class, 'goPremium'])->name('user.premium');
    Route::get('/set-read/{badge_id}', [UserController::class, 'setRead'])->name('user.set_read');
    Route::get('/logout', [AuthApiController::class, 'logout'])->name('auth.logout');


});

Route::middleware([checkToDoCount::class,'auth:sanctum'])->group(function () {
    Route::apiResource('/todos', TodoController::class)->only((['store','create']));
});


