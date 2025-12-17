<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class OtpVerification extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'user_id',
        'otp_code',
        'is_used',
        'purpose',
        'expires_at',
    ];
    protected $hidden = [
        'expires_at'
    ];
}
