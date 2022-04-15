<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class WalletController extends Controller
{
    //
    public function getAll()
    {
        return Wallet::select([
            'user_id',
            'amount',
            'reference_id'
        ])->get();

    }

    public function gettotalBalanceByUserId($id): JsonResponse
    {

        return response()->json(['amount is ' => Wallet::where('user_id', $id)->sum('amount')]);
    }
}
