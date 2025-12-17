<?php

namespace App\Http\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserService
{
    public $userRepo;
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function getAllUser()
    {
        return $this->userRepo->getAllUser();
    }

    public function getUserByEmail($email)
    {
        if(!isset($email))
        {
            throw new \Exception('Email can not be empty!!');
        }

        $user = $this->userRepo->getByEmail($email);
        if(empty($user))
        {
            throw new \Exception('User not found!!');
        }
        return $user;
    }

    public function getUserById(int $id)
    {
        $user = $this->userRepo->find($id);
        if (empty($user))
        {
            throw new \Exception('User not found!!');
        }
        return $user;
    }

    public function update(int $id, array $data)
    {
        DB::beginTransaction();
        try {
            if (!isset($data)) {
                throw new \Exception('Data can not be empty!!');
            }

            if (Auth::id() != $id) {
                throw new \Exception('Unauthorized attempt!!');
            }

            $user = $this->userRepo->update($id, $data);
            if (!$user) {
                throw new \Exception('Failed to update user!!');
            }

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            if (Auth::id() != $id) {
                throw new \Exception('Unauthorized attempt!!');
            }

            $this->userRepo->delete($id);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
