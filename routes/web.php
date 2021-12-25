<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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

// Route::get('/', function () {
//     return view('index');
// });


Route::group(['middleware' => [\App\Http\Middleware\checkToDoCount::class ] ], function() {
    // Route::apiResource('/todos', TodoController::class)->only((['create','store']));
    Route::get('/to/test', [ToDoController::class, 'test']);
});

// Route::get('/to/display', [ToDoController::class, 'test']);

// Route::get('/test', function () {
//     echo asset('storage/images/register.svg');
// });

Route::get('/{vue?}', function() {
    return view('index');
  })->where('vue', '[\/\w\.-]*');
