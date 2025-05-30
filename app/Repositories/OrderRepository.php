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
        ->whereRaw('ABS(price_per_gram - ?) < 0.0001', [$order->price_per_gram])
        ->get();
    }

    public function get($id, $userId)
    {
        return Order::where('user_id', $userId)->find($id);
    }

    public function getAll($filters, $userId)
    {
        $query = Order::where('user_id', $userId);

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(10);
    }
}
