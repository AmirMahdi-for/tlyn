<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateWalletRequest;
use App\Http\Resources\WalletResource;
use App\Services\WalletService;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }
    
    public function getWalletBalance(Request $request) 
    {
        $wallet = $this->walletService->getWallet($request->user()->id);

        return response()->json(['data' => new WalletResource($wallet)]);
    }

    public function updateWallet(UpdateWalletRequest $request) 
    {
        $this->walletService->updateWallet($request->validated(), $request->user()->id);

        return response()->json('ok', 200);
    }
}
