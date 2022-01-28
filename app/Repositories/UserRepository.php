<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{

    public function test()
    {
        //user auth?
        dd(['Users' => "text"]);
    }

    public function login(String $email_or_username, String $password): JsonResponse
    {

        $auth_check = $this->attemptLogin($email_or_username, $password);

        //  Login failed
        if (!$auth_check) {
            ReportService::reportLog("auth_check:false");
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        // Login successed
        return response()->json([
            'access_token' => $this->getAuthToken(),
            'token_type' => 'Bearer',
            'to' => 'display',
        ]);
    }

    public function register($validatedData) : JsonResponse
    {
        //no error validation,thus New User are registered along with the token
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => 'free_user',
        ]);

        //return token after succesfully registered
        return response()->json([
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'message_status' => "SUCCESS",
            "message" => "succesfully register account",
            'to' => "",
        ]);

    }

    private function getAuthToken(): String
    {
        /** @var \App\Models\User **/
        $user = Auth::user();
        return $user->createToken('auth_token')->plainTextToken;
    }

    private function attemptLogin(String $email_or_username, String $password): bool
    {
        $result = false;
        if (filter_var($email_or_username, FILTER_VALIDATE_EMAIL)) {
            $result = Auth::attempt(['email' => $email_or_username, 'password' => $password]);

        } else {
            $result = Auth::attempt(['username' => $email_or_username, 'password' => $password]);
        }

        return $result;
    }

}
