<?php

use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/test/todos', TodoController::class)->only((['index']));

Route::get('/test/users', [AuthApiController::class, 'test'])->name('test.users');

Route::get('/{vue?}', function () {
    return view('index');
})->where('vue', '[\/\w\.-]*');
