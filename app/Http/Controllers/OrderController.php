<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Mail\OrderSummaryMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private array $productPrices = [
        1 => 10.00,
        2 => 5.50,
        3 => 12.99,
    ];

    public function store(StoreOrderRequest $request): JsonResponse
    {
        if (!empty($request->honey_pot)) {
            return response()->json(['message' => 'Spam detected'], 422);
        }

        $validated = $request->validated();

        $total = $this->calculateTotal($validated['products']);

        $name = strip_tags($validated['name']);
        $email = filter_var($validated['email'], FILTER_SANITIZE_EMAIL);
        $phone = strip_tags($validated['phone']);
        $address = strip_tags($validated['address']);
        $paymentMethod = strip_tags($validated['payment_method']);

        $order = Order::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'payment_method' => $paymentMethod,
            'products' => $validated['products'],
            'total' => $total,
        ]);

        $adminEmail = config('mail.client.address');
        Mail::to($adminEmail)->send(new OrderSummaryMail($order));

        return response()->json([
            'message' => 'Comanda rebuda correctament!',
            'status' => 'success',
            'order_id' => $order->id
        ], 201);
    }

    private function calculateTotal(array $products): float
    {
        $total = 0.0;
        foreach ($products as $item) {
            $price = $this->productPrices[$item['id']] ?? 0.0; // Default to 0 if ID not found
            $total += $price * $item['quantity'];
        }
        return $total;
    }
}
