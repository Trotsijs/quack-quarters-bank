<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'crypto_portfolio';

    protected $fillable = [
        'account_id',
        'coin_id',
        'coin_symbol',
        'amount',
        'owner_id',
    ];
}
