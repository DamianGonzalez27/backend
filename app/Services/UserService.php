<?php
namespace App\Services;

use App\Repos\UserRepo;
use Tymon\JWTAuth\JWTAuth;
use App\Exceptions\AdminException;
use Illuminate\Contracts\Hashing\Hasher;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\BadCredentialsException;
use App\Exceptions\UserRegisteredException;

class UserService
{
    private $userRepo;
    private $auth;
    private $crypto;

    public function __construct(UserRepo $userRepo, JWTAuth $auth, Hasher $crypto)
    {
        $this->userRepo = $userRepo;
        $this->auth = $auth;
        $this->crypto = $crypto;
    }

    public function registerUser($email, $name, $password)
    {
        if ($this->userRepo->findFirst(['id'], ['email' => $email]))
            throw new UserRegisteredException('User already exists!');
        
        $this->userRepo->create([
            'email' => $email,
            'name' => $name,
            'password' => $this->crypto->make($password)
        ]);
        return "User created!";
    }

    public function signin($email, $password)
    {
        try {
            if (!$token = $this->auth->attempt(['email' => $email, 'password' => $password])) 
                throw new BadCredentialsException('Bad credentials');
        } catch (JWTException $e) {
            throw new AdminException('Internal server error!');
        }

        return $token;
    }

    public function signout(): String
    {
        try {
            $this->auth->parseToken()->invalidate();
        } catch (JWTException $e) {
            throw new AdminException('Internal server error!');
        }
        return "See you";
    }

    public function me($email)
    {
        $me = $this->userRepo->findFirst(['*'], ['email' => $email]);
        return [
            'name' => $me->name,
            'email' => $me->email,
            'store' => $me->store
        ];
    }
}