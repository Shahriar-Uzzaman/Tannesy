<?php

namespace App\Http\Services;

use App\Http\Repositories\OtpRepository;
use App\Http\Repositories\UserRepository;
use App\Mail\EmailVarificationStatus;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthService
{
    public function __construct(
        public UserRepository $userRepo,
        public OtpService $otpService,
    ) {}

    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            $data["password"] = Hash::make($data["password"]);
            $user = $this->userRepo->store($data);
            if (!$user) {
                throw new \Exception("Failed to create user!!");
            }

            $otp = rand(100000, 999999);
            $createOtp = $this->otpService->store(
                $user->id,
                $otp,
                "email_verification",
            );
            if (!$createOtp) {
                throw new \Exception("Failed to create otp!!");
            }

            $mailData = [
                "full_name" => $user["full_name"],
                "otp" => $otp,
            ];
            Mail::to($user["email"])->send(
                new VerifyEmail($mailData, "email_verification"),
            );

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function login(array $data)
    {
        $user = $this->userRepo->getByEmail($data["email"]);
        if (empty($user)) {
            throw new \Exception("Invalid credentials!!");
        }

        if (!$user->email_verified_at) {
            throw new \Exception("Email not verified");
        }

        if (!Hash::check($data["password"], $user->password)) {
            throw new \Exception("Invalid credentials pass!!");
        }

        // $user->tokens()->delete();
        $token = $user->createToken("token")->plainTextToken;
        return [
            "user" => $user,
            "token" => $token,
        ];
    }

    public function verifyOtp($data)
    {
        DB::beginTransaction();
        try {
            $userOtp = $this->otpService->getByUser(
                $data["user_id"],
                $data["purpose"],
            );
            if (empty($userOtp)) {
                throw new \Exception("Invalid Request!!");
            }

            $variftOp = $this->otpService->verifyOtp(
                $data["user_id"],
                $data["otp_code"],
                $data["purpose"],
            );
            if (!$variftOp) {
                throw new \Exception("Invalid otp!!");
            }

            $user = $this->userRepo->find($data["user_id"]);
            if (!$user) {
                throw new \Exception("User not found!!");
            }

            $x = $this->userRepo->update($user->id, [
                "email_verified_at" => now(),
            ]);
            $y = $this->otpService->delete($variftOp->id);
            if (!empty($x) && $y) {
                Mail::to($user["email"])->send(
                    new EmailVarificationStatus($variftOp->is_used),
                );
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function forgotPassword()
    {
        //
    }

    public function resendOtp()
    {
        //
    }
}
