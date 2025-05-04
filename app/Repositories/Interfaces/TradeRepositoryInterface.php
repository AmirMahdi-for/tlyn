<?php

namespace App\Repositories\Interfaces;

use App\Models\Order;

interface TradeRepositoryInterface
{
    public function create(Order $buyOrder, Order $sellOrder);
}