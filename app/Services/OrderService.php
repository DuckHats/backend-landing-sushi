<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Mail\OrderSummaryMail;
use App\Mail\OrderClientReceiptMail;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    /**
     * Place a new order.
     */
    public function placeOrder(array $data): Order
    {
        $processedProducts = $this->processProducts($data['products']);
        $total = array_reduce($processedProducts, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0.0);

        $order = Order::create([
            'name' => strip_tags($data['name']),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'phone' => strip_tags($data['phone']),
            'address' => strip_tags($data['address']),
            'payment_method' => strip_tags($data['payment_method']),
            'products' => $processedProducts,
            'total' => $total,
        ]);

        $this->sendEmails($order);

        return $order;
    }

    /**
     * Process product data to include names and prices.
     */
    protected function processProducts(array $products): array
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

    /**
     * Send order-related emails.
     */
    protected function sendEmails(Order $order): void
    {
        $adminEmail = config('customization.email');
        Mail::to($adminEmail)->send(new OrderSummaryMail($order));
        Mail::to($order->email)->send(new OrderClientReceiptMail($order));
    }
}
