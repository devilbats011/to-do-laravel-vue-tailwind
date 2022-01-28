<?php

namespace App\Interfaces;

use Illuminate\Http\JsonResponse;

interface UserRepositoryInterface 
{
    public function test();
    public function login(String $email_or_username,String $password) : JsonResponse ;
    public function register($validatedData) : JsonResponse;
}
