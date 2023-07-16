<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoCoin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'symbol',
        'description',
        'date_launched',
        'website',
        'price',
        'max_supply',
        'percent_change_24h',
        'percent_change_7d',
        'circulating_supply',
        'total_supply',
        'cmc_rank',
        'logo',

    ];

}
