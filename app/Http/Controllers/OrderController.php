<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
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

    public function get() 
    {
        
    }

    public function list() 
    {
        
    }

    public function cancel() 
    {
        
    }
}
