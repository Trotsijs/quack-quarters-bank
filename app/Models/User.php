<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PragmaRX\Google2FAQRCode\Google2FA;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'otp_secret',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * @var mixed
     */
    private $email;
    /**
     * @var mixed
     */
    private $otp_secret;

    public function accounts(): HasMany
    {
        return $this->hasMany(BankAccount::class, 'owner_id');
    }

    public function generateQrCode(): string
    {
        $google2fa = app('pragmarx.google2fa');
        return $google2fa->getQRCodeInline(
            config('app.name'),
            $this->email,
            $this->otp_secret
        );
    }
}
