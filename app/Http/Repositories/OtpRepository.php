<?php

namespace App\Http\Repositories;


use App\Models\OtpVerification;

class OtpRepository
{
    public function store(array $data)
    {
        return OtpVerification::create($data);
    }

    public function getUserOtp($id)
    {
        return OtpVerification::where('user_id', $id)->latest()->first();
    }

    public function getById($id)
    {
        return OtpVerification::where('user_id', $id)->first();
    }

    public function getUserOtpWithPurpose($id, $purpose)
    {
        return OtpVerification::where('user_id', $id)->where('purpose', $purpose)->first();
    }

    public function update($id, array $data)
    {
        return OtpVerification::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return OtpVerification::where('id', $id)->delete();
    }
}
