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
        // ایجاد Trade
        $trade = $this->tradeRepository->create($buyOrder, $sellOrder);

        // انتقال موجودی بین کیف‌پول‌ها
        $this->walletRepository->transferGoldToToman(
            $sellOrder->user_id,
            $buyOrder->user_id,
            $sellOrder->amount,
            $buyOrder->price_per_gram
        );

        // ثبت تراکنش برای خریدار
        $this->transactionRepository->create([
            'user_id' => $buyOrder->user_id,
            'type' => 'purchase',
            'asset' => 'gold',
            'amount' => $sellOrder->amount,
            // می‌تونی مقدار balance_after رو هم در آینده اضافه کنی
        ]);

        // ثبت تراکنش برای فروشنده
        $this->transactionRepository->create([
            'user_id' => $sellOrder->user_id,
            'type' => 'sell',
            'asset' => 'gold',
            'amount' => $sellOrder->amount,
        ]);

        return $trade;
    }
}
