<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface TransactionRepositoryInterface
{
    public function create(array $data);
}