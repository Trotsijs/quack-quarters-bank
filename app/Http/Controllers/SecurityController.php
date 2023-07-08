<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FAQRCode\Google2FA;

class SecurityController extends Controller
{
    public function index()
    {
        $otpSecret = Auth::user()->otp_secret;

        $company = 'Quack Quarters';
        $email = Auth::user()->email;

        $google2fa = app('pragmarx.google2fa');

        $qrCodeUrl = $google2fa->getQRCodeInline(
            $company,
            $email,
            $otpSecret
        );

        return view('security', ['qrCodeUrl' => $qrCodeUrl]);
    }
}
