<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLoginRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponse;

    //login function
    public function login(CreateLoginRequest $request)
    {
        $userData =  $request->validated();
        if (Auth::attempt($userData)) {
            $accessToken = Auth::user()->createToken('Auth Token')->accessToken;

            $data = new UserResource(auth()->user());
            return ApiResponse::successResponseWithData($data, 'Login successful', Response::HTTP_OK, $accessToken);
        }

        return ApiResponse::errorResponse('Invalid Login credentials', Response::HTTP_UNAUTHORIZED);
    }


    //register function
    public function register(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        //store user function here
        $createUser = User::create($data);

        $userResource = new UserResource($createUser);
        $accessToken = $userResource->createToken('Auth Token')->accessToken;
        return ApiResponse::successResponseWithData($userResource, 'Registration was successful', Response::HTTP_CREATED, $accessToken);
    }
}
