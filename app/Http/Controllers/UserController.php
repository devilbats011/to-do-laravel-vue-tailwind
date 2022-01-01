<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    function goPremium() {
        /** @var App\Models\User */
        $user = Auth::user();
        $user ->update(['user_type' => 'premium_user']);

        return response()->json([
            "message_status" => "SUCCESS",
            "to" => "display"
        ]);
    }
}