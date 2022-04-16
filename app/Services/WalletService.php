<?php

namespace App\Services;

use App\Models\Wallet;
use Carbon\Carbon;


class WalletService
{
    public function createTransactionReferenceId(): int
    {
        return rand(1000000, 9999999);
    }

    public function calculateDailyTransaction(Carbon $date)
    {
        $date = $date->toDateString();
        return Wallet::where('created_at', $date)->sum('amount');
    }

}
