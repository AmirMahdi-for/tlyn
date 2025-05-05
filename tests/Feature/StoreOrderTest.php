<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_store_buy_order_when_sufficient_balance()
    {
        $user = User::factory()->create();

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => 1_000_000,
            'balance_gold' => 10,
        ]);

        $payload = [
            'type' => 'buy',
            'amount' => 2,
            'price_per_gram' => 100_000,
        ];

        $response = $this->postJson('/api/orders/store', $payload, [
            'X-User-ID' => $user->id,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'type' => 'buy',
            'amount' => 2,
            'price_per_gram' => 100_000,
        ]);
    }

    public function test_user_cannot_store_buy_order_with_insufficient_balance()
    {
        $user = User::factory()->create();

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => 100_000,
            'balance_gold' => 0,
        ]);

        $payload = [
            'type' => 'buy',
            'amount' => 2,
            'price_per_gram' => 100_000,
        ];

        $response = $this->postJson('/api/orders/store', $payload, [
            'X-User-ID' => $user->id,
        ]);

        $response->assertStatus(500);
        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
        ]);
    }
}
