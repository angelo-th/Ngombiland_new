<?php

namespace App\Services\Auth;

class OTPService
{
    // Génère un OTP à 6 chiffres par défaut
    public function generateOTP($length = 6)
    {
        return str_pad(rand(0, pow(10, $length)-1), $length, '0', STR_PAD_LEFT);
    }

    // Vérifie l'OTP fourni par rapport à celui attendu
    public function verifyOTP($input, $otp)
    {
        return $input === $otp;
    }
}
