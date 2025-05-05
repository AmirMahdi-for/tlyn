<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StoreOrderTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_store_buy_order_when_sufficient_balance()
    {
        $user = $this->createUserWithSufficientBalance(5, 200_000);
        $payload = $this->validBuyPayload(5, 200_000);

        $response = $this->postBuyOrder($payload, $user);

        $response->assertStatus(201); 

        $this->assertOrderStored($user, $payload);
    }

    public function test_user_cannot_store_buy_order_with_insufficient_balance()
    {
        $user = $this->createUserWithInsufficientBalance(5, 200_000);
        $payload = $this->invalidBuyPayload(5, 200_000);

        $response = $this->postBuyOrder($payload, $user);

        $response->assertStatus(422);

        $this->assertOrderNotStored($user);
    }

    private function createUserWithSufficientBalance($amount, $pricePerGram)
    {
        $user = User::factory()->create();
        $totalPrice = $amount * $pricePerGram;

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => $totalPrice + 1,
            'balance_gold' => $amount,
        ]);

        return $user;
    }

    private function createUserWithInsufficientBalance($amount, $pricePerGram)
    {
        $user = User::factory()->create();
        $totalPrice = $amount * $pricePerGram;

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => $totalPrice - 1,
            'balance_gold' => 0,
        ]);

        return $user;
    }

    private function validBuyPayload($amount, $pricePerGram)
    {
        return [
            'type' => 'buy',
            'amount' => $amount,
            'price_per_gram' => $pricePerGram,
        ];
    }

    private function invalidBuyPayload($amount, $pricePerGram)
    {
        return [
            'type' => 'buy',
            'amount' => $amount,
            'price_per_gram' => $pricePerGram,
        ];
    }

    private function postBuyOrder($payload, $user)
    {
        return $this->postJson('fa/api/orders/store', $payload, [
            'X-User-ID' => $user->id,
        ]);
    }

    private function assertOrderStored($user, $payload)
    {
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'type' => 'buy',
            'amount' => $payload['amount'],
            'price_per_gram' => $payload['price_per_gram'],
        ]);
    }

    private function assertOrderNotStored($user)
    {
        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
        ]);
    }
}
