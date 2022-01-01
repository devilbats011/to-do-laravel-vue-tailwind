<?php

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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


Route::apiResource('/test/todos', TodoController::class)->only((['index']));

Route::get('/{vue?}', function() {
    return view('index');
  })->where('vue', '[\/\w\.-]*');

  /** 
   * 
   * $user->badges()->attach(1,2)
   * $user->badges()->detach(1,2)
   * $user->update([achieviement => 1])
   *         $number = ($_user['count']+1)/10;

        if(is_int($number)){
            $_user['achievements'] = $number;
        }
       badges_users notficitionStatus = none|unread|read
       todocontroller:store->response[...unread ,ownerId] -> frontend notify user -> frontend requets back to todocontroller:changeToReadStatus:(if(achieviement>1  ..bagde 1 is unread , ) Auth::user->badges()->updateExistingPivot($badgeId, [
    'notficitionStatus' => 'read',
]);)
       //$user = User::find(1);

$user->roles()->updateExistingPivot($roleId, [
    'active' => false,
]);
       -> frontend got response unread ->process->frontend request back read 
   */