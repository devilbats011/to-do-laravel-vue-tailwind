<?php

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\checkToDoCount;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthApiController;


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

Route::post('/login', [AuthApiController::class, 'login'])->named('auth.login');
Route::post('/register', [AuthApiController::class, 'register'])->named('auth.register');

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     Route::apiResource('/todos', TodoController::class)->except((['create','index']));
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('/todos', TodoController::class)->except((['create','store','index']));

    Route::post('/logout', [AuthApiController::class, 'logout'])->named('auth.logout');
});

Route::middleware([checkToDoCount::class,'auth:sanctum'])->group(function () {
    // Route::apiResource('/todos', TodoController::class)->only((['create','store']));
    Route::get('/to/test', [ToDoController::class, 'test']);
});

// Route::group(['middleware' => [\App\Http\Middleware\checkToDoCount::class] ], function() {
//     Route::get('/to/test', [ToDoController::class, 'test']);
// });

// Route::middleware([checkToDoCount::class])->group(function () {
   
    // Route::post('/create', [TodoController::class, 'create'])->named('todo.create');
// });
