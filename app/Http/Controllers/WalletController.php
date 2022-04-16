<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Services\WalletService;
use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;



class WalletController extends Controller
{

    private WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //
    public function getAll()
    {
        return Wallet::select([
            'user_id',
            'amount',
            'reference_id'
        ])->get();

    }

    public function getTotalBalanceByUserId($id): JsonResponse
    {

       return response()->json(['amount is ' => Wallet::where('user_id', $id)->sum('amount')]);
    }

    public function getDailyBalance()
    {

        return response()->json(['daily Amount' => $this->walletService->calculateDailyTransaction(Carbon::yesterday())]);

    }

    public function addBalance(Request $request)
    {
        $reference_id = $this->walletService->createTransactionReferenceId();

        $wallet = new Wallet();
        $wallet->user_id = $request->user_id;
        $wallet->created_at = Carbon::yesterday()->toDateString();

        $wallet->amount = $request->amount;
        $wallet->reference_id = $reference_id;

        $wallet->save();

        return response()->json(['reference_id' => $reference_id]);

    }
}
