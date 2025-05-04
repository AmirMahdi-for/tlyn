<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface 
{
    public function create(array $data)
    {
        return Transaction::create($data);
    }
}
