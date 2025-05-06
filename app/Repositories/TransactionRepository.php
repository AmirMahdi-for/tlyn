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

    public function get(int $id, int $userId)
    {
        return Transaction::where('user_id', $userId)->find($id);
    }
    public function getAll(array $filters, $userId)
    {
        $query = Transaction::where('user_id', $userId);

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        return $query->paginate(10);
    }
}
