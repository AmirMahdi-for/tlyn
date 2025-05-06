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
                throw new InsufficientBalanceException(__('messages.insufficient_balance'));
            }
        } else {
            if ($wallet->balance_gold < $amount) {
                throw new InsufficientBalanceException(__('messages.insufficient_balance'));
            }
        }

        return true;
    }

    public function updateWallet($data, $userId) 
    {
        
        DB::transaction(function () use ($data, $userId) {
            
            $wallet = $this->walletRepository->getByUserId($userId);
            
            if (!$wallet) {
                $wallet = $this->walletRepository->create([
                    'user_id' => $userId,
                    'balance_toman' => 0,
                ]);
            }

            if ($data['type'] === 'withdraw') {
                if ($wallet->balance_toman < $data['amount']) {
                    throw new \Exception(__('messages.insufficient_balance'));
                }

                $wallet->balance_toman -= $data['amount'];
            }

            if ($data['type'] === 'deposit') {
                $wallet->balance_toman += $data['amount'];
            }

            $wallet->save();
        });
    }

    public function getWallet($userId) 
    {
        $wallet = $this->walletRepository->getByUserId($userId);
        return $wallet;
    }
}
