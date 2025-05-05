<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\TransactionRepository;
use App\Repositories\TradeRepository;
use App\Repositories\WalletRepository;
class TradeService
{
    protected $tradeRepository;
    protected $transactionRepository;
    protected $walletRepository;

    public function __construct(
        TradeRepository $tradeRepository,
        TransactionRepository $transactionRepository,
        WalletRepository $walletRepository
    ) {
        $this->tradeRepository = $tradeRepository;
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
    }

    public function create(Order $buyOrder, Order $sellOrder)
    {
        $trade = $this->tradeRepository->create($buyOrder, $sellOrder);

        $this->walletRepository->transferGoldToToman(
            $sellOrder->user_id,
            $buyOrder->user_id,
            $sellOrder->amount,
            $buyOrder->price_per_gram
        );

        $buyWallet = $this->walletRepository->getByUserId($buyOrder->user_id);
        $buyBalanceAfter = $buyWallet->balance_toman - ($sellOrder->amount * $buyOrder->price_per_gram);

        $this->transactionRepository->create([
            'user_id' => $buyOrder->user_id,
            'type' => 'purchase',
            'asset' => 'gold',
            'amount' => $sellOrder->amount,
            'balance_after' => $buyBalanceAfter,
        ]);

        $sellWallet = $this->walletRepository->getByUserId($sellOrder->user_id);
        $sellBalanceAfter = $sellWallet->balance_gold + $sellOrder->amount;

        $this->transactionRepository->create([
            'user_id' => $sellOrder->user_id,
            'type' => 'sell',
            'asset' => 'gold',
            'amount' => $sellOrder->amount,
            'balance_after' => $sellBalanceAfter, 
        ]);

        return $trade;
    }
}
