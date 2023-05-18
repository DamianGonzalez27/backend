<?php
namespace App\Repos;

use App\Models\User;
use App\Repos\RepoBase;

class UserRepo extends RepoBase
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create($data)
    {
        return User::insertGetId($data);
    }
}