<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Services\CryptoApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cryptoApiService = new CryptoApiService();

        $portfolioData = Portfolio::where('owner_id', $user->id)->get();

        $totalPortfolioValue = 0;

        foreach ($portfolioData as $portfolio) {
            $coinId = $portfolio->coin_id;
            $coinInfo = $cryptoApiService->getCoinById($coinId)->quote->USD;
            $portfolio->coin_price = $coinInfo->price;


            if (is_numeric($portfolio->coin_price) && is_numeric($portfolio->amount)) {
                $portfolio->coin_value = $portfolio->coin_price * $portfolio->amount;
                $totalPortfolioValue += $portfolio->coin_value;
            } else {

                $portfolio->coin_value = 0;
            }
        }

        return view('portfolio', compact('portfolioData', 'totalPortfolioValue'));
    }
}
