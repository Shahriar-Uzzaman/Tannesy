<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo =$userRepo;
    }

    public function register(array $data)
    {
        DB::beginTransaction();
        try
        {
            if(!isset($data))
            {
                throw new \Exception('Input field can not be empty!!');
            }

            $data['password'] = Hash::make($data['password']);
            $user = $this->userRepo->store($data);
            if(!$user)
            {
                throw new \Exception('Failed to create user!!');
            }
            DB::commit();
            return $user;
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            throw $e;
        }
    }

    public function login(array $data)
    {
        DB::beginTransaction();
        try
        {
            $user = $this->userRepo->getByEmail($data['email']);
            if(!$user)
            {
                throw new \Exception('Invalid credentials!!');
            }

            if(!Hash::check($data['password'], $user->password))
            {
                throw new \Exception('Invalid credentials!!');
            }

            $user->token()->delete();
            $token = $user->createToken('token')->plainTextToken;
            DB::commit();
            return [
                'user' => $user,
                'token' => $token
            ];
        }
        catch (\Exception$e)
        {
            DB::rollBack();
            throw $e;
        }
    }
}
