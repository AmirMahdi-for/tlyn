<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Repositories\WalletRepository;
use Illuminate\Support\Facades\DB;

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
                throw new InsufficientBalanceException('Insufficient balance');
            }
        } else {
            if ($wallet->balance_gold < $amount) {
                throw new InsufficientBalanceException('Insufficient balance');
            }
        }

        return true;
    }

    public function updateWallet($data, $userId) 
    {
        $wallet = $this->walletRepository->getByUserId($userId);

        if ($data['type'] == 'withdraw') {
            if ($wallet->balance_toman < $data['amount']) {
                throw new \Exception('موجودی کافی برای برداشت وجود ندارد');
            }
    
            $wallet->updateOrCreate(
                ['user_id' => $userId],
                [
                    'balance_toman' => DB::raw("balance_toman - {$data['amount']}") 
                ]
            );
        }
    
        if ($data['type'] == 'deposit') {
            $wallet->updateOrCreate(
                ['user_id' => $userId], 
                [
                    'balance_toman' => DB::raw("balance_toman + {$data['amount']}")
                ]
            );
        }
    }

    public function getWallet($userId) 
    {
        $wallet = $this->walletRepository->getByUserId($userId);
        return $wallet;
    }
}
