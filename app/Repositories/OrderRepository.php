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

    public function get(int $id, int $userId)
    {
        return Order::where('user_id', $userId)->find($id);
    }

    public function list(array $filters = [])
    {
        $query = Order::query(); // ساخت یک query پایه برای سفارش‌ها

        // اعمال فیلترها به query
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        return $query->get(); // گرفتن نتایج
    }

}
