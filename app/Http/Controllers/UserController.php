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
            "message" => "Thank you for becomimg Premium Member!",
            "to" => "display"
        ]);
    }

    function setRead($badge_id) {
        /** @var App\Models\User */
        $user = Auth::user();
        $user ->onRead($badge_id);

        return response()->json([
            "message" => "unread had set to read",
        ],200);
    }
}