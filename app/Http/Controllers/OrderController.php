<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\Paginated\OrderResource as PaginatedOrderResource;
use App\Http\Resources\Paginated\OrderResources;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }
    
    public function store(StoreOrderRequest $request) 
    {
        $order = $this->orderService->store($request->validated(), $request->user()->id);

        return response()->json(['order' => $order], 201);
    }

    public function get($locale, $id, Request $request) 
    {
        $order = $this->orderService->getById($id, $request->user()->id);

        return response()->json(['data' => new OrderResource($order)]);
    }

    public function list(Request $request) 
    {
        $orders = $this->orderService->getAll($request->user()->id);

        return response()->json(['data' => new OrderResources($orders)], 200);
    }

    public function cancel($locale, $id, Request $request) 
    {
        $order = $this->orderService->getById($id, $request->user()->id);

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        if ($order->status === 'completed') {
            return response()->json(['error' => 'Completed orders cannot be cancelled'], 400);
        }

        $this->orderService->cancelOrder($id);

        return response()->json(['message' => 'Order cancelled successfully'], 200);
    }

}
