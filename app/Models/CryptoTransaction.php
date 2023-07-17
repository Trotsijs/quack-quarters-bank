<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'coin_id',
        'coin_symbol',
        'coin_price',
        'coin_amount',
        'type',
        'spent',
    ];
}
