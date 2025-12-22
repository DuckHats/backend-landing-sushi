<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationRequestMail;
use App\Mail\ReservationClientReceiptMail;
use App\Mail\OrderSummaryMail;
use App\Mail\OrderClientReceiptMail;
use App\Models\User;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_reservation_sends_email_to_admin_and_client()
    {
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/reservations', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '123456789',
            'persons' => 2,
            'date_time' => now()->addDay()->format('Y-m-d H:i:s'),
        ]);

        $response->assertStatus(201);

        Mail::assertSent(ReservationRequestMail::class);
        Mail::assertSent(ReservationClientReceiptMail::class, function ($mail) {
            return $mail->hasTo('john@example.com');
        });
    }

    public function test_order_sends_email_to_admin_and_client()
    {
        Mail::fake();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/delivery-orders', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'phone' => '987654321',
            'address' => '123 Main St',
            'payment_method' => 'cash',
            'products' => [
                ['id' => 1, 'quantity' => 2],
            ],
        ]);

        $response->assertStatus(201);

        Mail::assertSent(OrderSummaryMail::class);
        Mail::assertSent(OrderClientReceiptMail::class, function ($mail) {
            return $mail->hasTo('jane@example.com');
        });
    }
}
