<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{

    public function login(Request $request)
    {
        $email_or_username = $request->input('email_or_username');
        $password = $request->input('password');
        $checkField = 0;

            //user use email
        if (filter_var($email_or_username, FILTER_VALIDATE_EMAIL)) {
            Auth::attempt(['email' => $email_or_username, 'password' => $password]);
            $checkField = 1;
        } else {
            //user use username
            Auth::attempt(['username' => $email_or_username, 'password' => $password]);
            $checkField = 2;
        }

        // return invalid message when fail Auth
        if (!Auth::check()) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        /** @var \App\Models\user **/
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // return token when User login
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'check_field' => $checkField,
        ]);
    }

       // method for user logout and delete token
       public function logout()
       {
        /** @var \App\Models\user **/
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
             'message' => 'You have successfully logged out and the token was successfully deleted'
        ]);
       }
       

    public function register(Request $request)
    {
        //phone digit based on -> https://en.wikipedia.org/wiki/Telephone_numbers_in_Malaysia, to be safe -> min:8
        
        //Catch and return error validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:16|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:8',
            'password' => 'required|string|min:8',
        ]);

        //no error validation,thus New User are registered along with the token
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']),
            'user_type' => 'free_user',
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        //return token after succesfully registered
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
