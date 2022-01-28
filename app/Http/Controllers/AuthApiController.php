<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use App\Interfaces\UserRepositoryInterface;

class AuthApiController extends Controller
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) 
    {
        $this->userRepository = $userRepository;
    }

    public function test(){
        $this->userRepository->test();
    }

    public function login(Request $request) : JsonResponse
    {

        $validatedData = $request->validate([
            'email_or_username' => 'required|max:255',
            'password' => 'required|string|min:8',
        ]);

        $email_or_username = $validatedData['email_or_username'];
        $password = $validatedData['password'];

        return $this->userRepository->login($email_or_username, $password);
    }

    // method for user logout and delete token
    public function logout()
    {
        /** @var \App\Models\user **/
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
            'message' => 'You have successfully logged out.',
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

        return $this->userRepository->register($validatedData);

    }

    public function getTheUser()
    {

        /** @var \App\Models\user */
        $user = Auth::user();

        return response()->json([
            'name' => $user->name,
            'username' => $user->username,
            'user_type' => $user['user_type'],
        ]);
    }
}
