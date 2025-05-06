<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface TransactionRepositoryInterface
{
    public function create(array $data);
    public function get(int $id, int $userId);
    public function getAll(array $filters, $userId);

}