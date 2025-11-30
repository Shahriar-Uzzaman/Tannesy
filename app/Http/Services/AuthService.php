<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;

class AuthService
{
    public $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo =$userRepo;
    }

    public function register(array $data)
    {
        try
        {

        }
        catch (\Exception $e)
        {

        }
    }
}
