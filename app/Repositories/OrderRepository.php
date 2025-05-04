<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface 
{
    public function create($data, $userId)
    {
        return Order::create([
            'user_id' => $userId,
            'type' => $data['type'],
            'price_per_gram' => $data['price_per_gram'],
            'amount' => $data['amount'],
            'remaining_amount' => $data['amount'],
        ]);
    }

    public function getOpenOrders(Order $order)
    {
        return Order::where('status', 'open')
            ->where('type', $order->type === 'buy' ? 'sell' : 'buy')
            ->where('price_per_gram', $order->price_per_gram)
            ->get();
    }
}
