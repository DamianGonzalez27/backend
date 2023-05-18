<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;

class AuthController extends Controller
{

    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function signup(SignUpRequest $request)
    {
        return $this->basicResponse(
            $this->userService->registerUser(
                $request->input('email'),
                $request->input('name'),
                $request->input('password')
            )
        );
    }

    public function signin(SignInRequest $request)
    {   
        return $this->responseWhidthData('Welcome', [
            'token' => $this->userService->signin($request->input('email'), $request->input('password')),
            'user' => $this->userService->me($request->input('email'))
        ]);
    }

    public function signout()
    {
        return $this->basicResponse(
            $this->userService->signout()
        );
    }

}
