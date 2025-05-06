<?php

namespace App\Repositories;

use App\Models\Wallet;
use App\Repositories\Interfaces\WalletRepositoryInterface;
class WalletRepository implements WalletRepositoryInterface 
{
    public function create(array $data)
    {
        return Wallet::create($data);
    }
    
    public function getByUserId(int $userId): ?Wallet
    {
        return Wallet::where('user_id', $userId)->first();
    }

    public function updateBalanceToman(int $userId, int $amount): Wallet
    {
        $wallet = $this->getByUserId($userId);
        $wallet->balance_toman += $amount;
        $wallet->save();

        return $wallet;
    }

    public function updateBalanceGold(int $userId, float $amount): Wallet
    {
        $wallet = $this->getByUserId($userId);
        $wallet->balance_gold += $amount;
        $wallet->save();

        return $wallet;
    }

    public function setBalances(int $userId, int $toman, float $gold): Wallet
    {
        $wallet = $this->getByUserId($userId);
        $wallet->balance_toman = $toman;
        $wallet->balance_gold = $gold;
        $wallet->save();

        return $wallet;
    }

    public function hasSufficientToman(int $userId, int $amount): bool
    {
        $wallet = $this->getByUserId($userId);
        return $wallet->balance_toman >= $amount;
    }

    public function hasSufficientGold(int $userId, float $amount): bool
    {
        $wallet = $this->getByUserId($userId);
        return $wallet->balance_gold >= $amount;
    }

    public function transferGoldToToman(int $sellerId, int $buyerId, float $amount, int $pricePerGram): void
    {
        $totalPrice = $amount * $pricePerGram;

        // Buyer:
        $this->updateBalanceGold($buyerId, $amount);         // Gold +
        $this->updateBalanceToman($buyerId, -$totalPrice);   // Toman -

        // Seller:
        $this->updateBalanceGold($sellerId, -$amount);       // Gold -
        $this->updateBalanceToman($sellerId, $totalPrice);   // Toman +
    }
}
