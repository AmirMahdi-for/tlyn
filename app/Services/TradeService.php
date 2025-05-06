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
        $tradeAmount = $sellOrder->amount;

        $trade = $this->tradeRepository->create($buyOrder, $sellOrder);

        $this->walletRepository->transferGoldToToman(
            $sellOrder->user_id,
            $buyOrder->user_id,
            $tradeAmount,
            $buyOrder->price_per_gram
        );

        $buyWallet = $this->walletRepository->getByUserId($buyOrder->user_id);
        $buyBalanceAfter = $buyWallet->balance_toman - ($tradeAmount * $buyOrder->price_per_gram);

        $this->transactionRepository->create([
            'user_id' => $buyOrder->user_id,
            'type' => 'purchase',
            'asset' => 'gold',
            'amount' => $tradeAmount,
            'balance_after' => $buyBalanceAfter,
        ]);

        $sellWallet = $this->walletRepository->getByUserId($sellOrder->user_id);
        $sellBalanceAfter = $sellWallet->balance_gold + $tradeAmount;

        $this->transactionRepository->create([
            'user_id' => $sellOrder->user_id,
            'type' => 'sell',
            'asset' => 'gold',
            'amount' => $tradeAmount,
            'balance_after' => $sellBalanceAfter, 
        ]);

        $buyOrder->filled_amount += $tradeAmount;
        if ($buyOrder->filled_amount >= $buyOrder->amount) {
            $buyOrder->status = Order::STATUS_COMPLETED;
        }
        $buyOrder->save();

        $sellOrder->filled_amount += $tradeAmount;
        if ($sellOrder->filled_amount >= $sellOrder->amount) {
            $sellOrder->status = Order::STATUS_COMPLETED;
        }
        $sellOrder->save();

        return $trade;
    }
}
