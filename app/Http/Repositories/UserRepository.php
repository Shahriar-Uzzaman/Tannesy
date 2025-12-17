<?php

namespace App\Http\Repositories;


use App\Models\User;

class UserRepository
{
    public function getByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function find($id)
    {
        return User::where('id', $id)->first();
    }

    public function getAllUser()
    {
        return User::all();
    }

    public function store(array $data)
    {
        return User::create($data);
    }

    public function update($id, array $data)
    {
        return User::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return User::where('id', $id)->delete();
    }
}
