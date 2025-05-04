<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Trade;
use App\Repositories\Interfaces\TradeRepositoryInterface;

class TradeRepository implements TradeRepositoryInterface 
{
    public function create(Order $buyOrder, Order $sellOrder)
    {
        return Trade::create([
            'buy_order_id' => $buyOrder->id,
            'sell_order_id' => $sellOrder->id,
            'price_per_gram' => $buyOrder->price_per_gram,
            'amount' => $sellOrder->amount,
            'total_price' => $buyOrder->price_per_gram * $sellOrder->amount,
            'commission' => $this->calculateCommission($buyOrder, $sellOrder),
        ]);
    }

    private function calculateCommission(Order $buyOrder, Order $sellOrder)
    {
        return ($buyOrder->price_per_gram * $sellOrder->amount) * 0.01;
    }
}
