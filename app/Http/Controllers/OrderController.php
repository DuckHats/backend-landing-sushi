<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Mail\OrderSummaryMail;
use App\Mail\OrderClientReceiptMail;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private array $productPrices = [];

    public function store(StoreOrderRequest $request): JsonResponse
    {
        if (!empty($request->honey_pot)) {
            return response()->json(['message' => config('app_texts.order.spam_detected')], 422);
        }

        $validated = $request->validated();

        // Process products to include names and prices
        $processedProducts = $this->processProducts($validated['products']);
        $total = array_reduce($processedProducts, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0.0);

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
            'products' => $processedProducts,
            'total' => $total,
        ]);

        $adminEmail = config('mail.client.email');
        Mail::to($adminEmail)->send(new OrderSummaryMail($order));
        Mail::to($order->email)->send(new OrderClientReceiptMail($order));

        return response()->json([
            'message' => config('app_texts.order.success'),
            'status' => 'success',
            'order_id' => $order->id
        ], 201);
    }

    private function processProducts(array $products): array
    {
        $processed = [];

        foreach ($products as $item) {
            $product = Product::where('product_code', (string) $item['id'])->first();

            if ($product) {
                $processed[] = [
                    'id' => $item['id'],
                    'name' => $product->name,
                    'price' => (float) $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => (float) $product->price * $item['quantity'],
                ];
            }
        }

        return $processed;
    }
}
