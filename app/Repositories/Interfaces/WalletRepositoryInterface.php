<?php

namespace App\Repositories\Interfaces;

use App\Models\Wallet;

interface WalletRepositoryInterface
{
    public function getByUserId(int $userId): Wallet;
    public function updateBalanceToman(int $userId, int $amount): Wallet;
    public function updateBalanceGold(int $userId, float $amount): Wallet;
    public function setBalances(int $userId, int $toman, float $gold): Wallet;
    public function hasSufficientToman(int $userId, int $amount): bool;
    public function hasSufficientGold(int $userId, float $amount): bool;
}