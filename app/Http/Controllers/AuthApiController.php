<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {

        $validatedData = $request->validate([
            'email_or_username' => 'required|max:255',
            'password' => 'required|string|min:8',
        ]);

        $email_or_username = $validatedData['email_or_username'];
        $password = $validatedData['password'];
        // $content = "email_or_username: ".$email_or_username." | password: ".$password;
        // Storage::disk('local')->append('todo-auth-log/log.txt', $content );
        // return response()->json([$email_or_username,$password ]);
            //user use email
              // if($result2 == true){
            //     Storage::disk('local')->append('todo-auth-log/log', "username_Auth Attempt::true");

            // }
            // else{

            //     Storage::disk('local')->append('todo-auth-log/log', "username_Auth Attempt::false");
                // Storage::disk('local')->append('todo-auth-log/log.txt', "email_Auth Attempt::".$result);

            // }
        $auth_check=false;
        if (filter_var($email_or_username, FILTER_VALIDATE_EMAIL)) {
            $auth_check = Auth::attempt(['email' => $email_or_username, 'password' => $password]);
            
        } else {
            //user use username
            $auth_check = Auth::attempt(['username' => $email_or_username, 'password' => $password]);
        }

        // return invalid message when fail Auth
        if (!$auth_check) {
             Storage::disk('local')->append('todo-auth-log/log.txt', "auth_check::false");
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        /** @var \App\Models\user **/
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // return token when User login
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'to' => 'display'
        ]);
    }

       // method for user logout and delete token
       public function logout()
       {
        /** @var \App\Models\user **/
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
             'message' => 'You have successfully logged out.'
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
            'message_status' => "SUCCESS",
            'to' => ""
        ]);
    }

    public function getTheUser() {

        /** @var \App\Models\user */
        $user = Auth::user();
        
        return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'user_type' => $user['user_type'],
        ]);
    }
}
