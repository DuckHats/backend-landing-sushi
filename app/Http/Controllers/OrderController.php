<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        if (!empty($request->honey_pot)) {
            return response()->json(['message' => config('app_texts.order.spam_detected')], 422);
        }

        $order = $this->orderService->placeOrder($request->validated());

        return (new OrderResource($order))
            ->response()
            ->setStatusCode(201);
    }
}
