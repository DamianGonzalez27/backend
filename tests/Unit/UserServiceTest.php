<?php

namespace Tests\Unit;

use Mockery;
use App\Repos\UserRepo;
use Tymon\JWTAuth\JWTAuth;
use App\Services\UserService;
use PHPUnit\Framework\TestCase;
use App\Exceptions\AdminException;
use Illuminate\Contracts\Hashing\Hasher;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Exceptions\BadCredentialsException;
use App\Exceptions\UserRegisteredException;

class UserServiceTest extends TestCase
{
    protected $jwt;
    protected $crypto;
    protected $userRepo;
    protected $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->jwt = Mockery::mock(JWTAuth::class);
        $this->crypto = Mockery::mock(Hasher::class);
        $this->userRepo = Mockery::mock(UserRepo::class);

        $this->service = new UserService(
            $this->userRepo, 
            $this->jwt,
            $this->crypto
        );
    }

    public function testRegisterUserUserExists(): void
    {
        $this->userRepo->shouldReceive('findFirst')->once()->andReturn(true);
        $this->expectException(UserRegisteredException::class);
        $this->service->registerUser('', '', '');
    }

    public function testRegisterUser(): void
    {
        $this->userRepo->shouldReceive('findFirst')->once()->andReturn(null);
        $this->crypto->shouldReceive('make')->once()->andReturn('123');
        $this->userRepo->shouldReceive('create')->once()->andReturn(true);

        $this->assertEquals(
            'User created!', 
            $this->service->registerUser('email', 'name', 'password')
        );
    }

    public function testSignInBadCredentials(): void
    {
        $this->jwt->shouldReceive('attempt')->once()->andReturn(null);
        $this->expectException(BadCredentialsException::class);
        $this->service->signin('', '', '');
    }

    public function testSignInAdminError(): void
    {
        $this->jwt->shouldReceive('attempt')->andThrow(JWTException::class);
        $this->crypto->shouldReceive('make')->once()->andReturn('123');
        $this->expectException(AdminException::class);
        $this->service->signin('', '', '');
    }

    public function testSignOutAdminError(): void
    {
        $this->jwt->shouldReceive('parseToken')->andThrow(JWTException::class);
        $this->expectException(AdminException::class);
        $this->service->signout();
    }

    public function testSignOut(): void
    {
        $this->jwt->shouldReceive('parseToken')->andReturnSelf();
        $this->jwt->shouldReceive('invalidate')->andReturnTrue();
        $this->assertEquals(
            'See you', 
            $this->service->signout()
        );
    }
}