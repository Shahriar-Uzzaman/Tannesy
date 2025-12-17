<?php

namespace App\Http\Services;

use App\Http\Repositories\OtpRepository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OtpService
{
    public $otpRepository;
    public function __construct(OtpRepository $otpRepository)
    {
        $this->otpRepository = $otpRepository;
    }

    public function store($userId, $otp, $purpose)
    {
        $this->otpRepository->store([
            'user_id' => $userId,
            'otp_code' => $otp,
            'purpose' => $purpose,
            'expires_at' => now()->addMinute(10)
        ]);
        return true;
    }

    public function getByUser($id, $purpose)
    {
        return $this->otpRepository->getUserOtpWithPurpose($id, $purpose);
    }

    public function verifyOtp($user, $otp, $purpose)
    {
        if(!isset($user) || !isset($otp))
        {
            throw new \Exception('Input field can not be empty!!');
        }

        $otpVerification = $this->otpRepository->getUserOtp($user);
        if(empty($otpVerification))
        {
            throw new \Exception('Invalid Request!!');
        }

        if($otpVerification->purpose != $purpose || $otpVerification->is_used || $otpVerification->expires_at < now() || $otpVerification->otp_code != $otp)
        {
            throw new \Exception('Invalid OTP or Expired or Already Used or Invalid Purpose!!');
        }

        $this->otpRepository->update($otpVerification->id,['is_used' => true]);
        $otpVerification->is_used = true;
        return $otpVerification;

    }

    public function updateOtp($id, $data)
    {
        $otpUpdate = $this->otpRepository->getUserOtp($id);
        if(!$otpUpdate)
        {
            throw new \Exception('Otp not found!!');
        }

        $otpUpdate->update($data);
        return true;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $otp = $this->otpRepository->getById($id);
            if($otp) {
                $this->otpRepository->delete($id);
                DB::commit();
                return true;
            }
            DB::commit();
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
