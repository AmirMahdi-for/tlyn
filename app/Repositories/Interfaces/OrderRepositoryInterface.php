<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function create(array $data, int $userId);
    public function getOpenOrders(Order $order);
    public function get(int $id, int $userId);
    public function getAll(array $filters, int $userId);
}