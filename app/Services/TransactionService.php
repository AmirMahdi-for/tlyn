<?php

namespace App\Services;

use App\Models\Trade;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;

class TransactionService
{
    protected $transactionRepository;
    protected $walletRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        WalletRepository $walletRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
    }

    public function createPurchaseTransaction(int $userId, float $amount, string $asset = 'gold')
    {
        $wallet = $this->walletRepository->getByUserId($userId);

        return $this->transactionRepository->create([
            'user_id' => $userId,
            'type' => 'purchase',
            'asset' => $asset,
            'amount' => $amount,
            'balance_after' => $this->getAssetBalance($wallet, $asset),
        ]);
    }

    public function createSellTransaction(int $userId, float $amount, string $asset = 'gold')
    {
        $wallet = $this->walletRepository->getByUserId($userId);

        return $this->transactionRepository->create([
            'user_id' => $userId,
            'type' => 'sell',
            'asset' => $asset,
            'amount' => $amount,
            'balance_after' => $this->getAssetBalance($wallet, $asset),
        ]);
    }

    private function getAssetBalance(Wallet $wallet, string $asset): float|int
    {
        return match ($asset) {
            'gold' => $wallet->balance_gold,
            'toman' => $wallet->balance_toman,
            default => 0,
        };
    }
}
