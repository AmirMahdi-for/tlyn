<?php

namespace App\Services;

use App\Repositories\WalletRepository;

class WalletService
{
    protected $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function hasSufficientBalance($type, $amount, $pricePerGram, $userId)
    {
        $wallet = $this->walletRepository->getByUserId($userId);

        if ($type === 'buy') {
            $totalPrice = $amount * $pricePerGram;
            if ($wallet->balance_toman < $totalPrice) {
                throw new InsufficientBalanceException('موجودی کافی نیست');
            }
        } else {
            if ($wallet->balance_gold < $amount) {
                throw new InsufficientBalanceException('موجودی کافی نیست');
            }
        }

        return true;
    }
}
