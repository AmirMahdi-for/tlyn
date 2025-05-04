<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data, int $userId);
    public function getOpenOrders(Order $order);
}