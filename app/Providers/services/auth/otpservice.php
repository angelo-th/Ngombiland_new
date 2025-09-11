<?php

namespace App\Services\Auth;

use App\Models\Auth\OTP;
use App\Services\MobileMoney\MTNMobileMoneyService;
use Illuminate\Support\Str;

class OTPService
{
    protected $mobileMoneyService;

    public function __construct(MTNMobileMoneyService $mobileMoneyService)
    {
        $this->mobileMoneyService = $mobileMoneyService;
    }

    public function sendOTP(string $phone)
    {
        $otp = rand(100000, 999999);
        $reference = Str::uuid();

        // Enregistrement en base
        OTP::create([
            'phone' => $phone,
            'otp' => $otp,
            'reference' => $reference,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Envoi via Mobile Money USSD
        $this->mobileMoneyService->sendSMS($phone, "Votre code OTP NGOMBILAND: $otp");

        return [
            'reference' => $reference,
            'expires_at' => now()->addMinutes(10)->toDateTimeString(),
        ];
    }

    public function verifyOTP(string $phone, string $otp, string $reference)
    {
        $otpRecord = OTP::where('phone', $phone)
            ->where('otp', $otp)
            ->where('reference', $reference)
            ->where('expires_at', '>', now())
            ->first();

        if (! $otpRecord) {
            return false;
        }

        // Suppression de l'OTP après vérification
        $otpRecord->delete();

        return true;
    }
}
