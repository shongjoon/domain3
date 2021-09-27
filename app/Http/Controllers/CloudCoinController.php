<?php

namespace App\Http\Controllers;

use App\CloudCoin;

class CloudCoinController extends Controller
{
    public function getCoins()
    {
        return $account_coin = CloudCoin::selectRaw('*,sum(account_coin) as coin')
            ->get();

    }
}
