<?php

namespace App\Services;

use App\Models\Order;
use App\Repositories\OrderRepository;
use App\Services\WalletService;
use App\Services\TradeService;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository;
    protected $walletService;
    protected $tradeService;

    public function __construct(OrderRepository $orderRepository, WalletService $walletService, TradeService $tradeService)
    {
        $this->orderRepository = $orderRepository;
        $this->walletService = $walletService;
        $this->tradeService = $tradeService;
    }

    public function store($data, $userId)
    {
        $this->walletService->hasSufficientBalance($data['type'], $data['amount'], $data['price_per_gram'], $userId);

        $order = $this->orderRepository->create($data, $userId);

        $this->match($order);

        return $order;
    }

    public function match(Order $order)
    {
        $openOrders = $this->orderRepository->getOpenOrders($order);

        if ($openOrders->isNotEmpty()) {
            foreach ($openOrders as $openOrder) {
                $this->tradeService->create($order, $openOrder);
            }
        }
    }
}
