<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;

class UserService
{
    public $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

}
