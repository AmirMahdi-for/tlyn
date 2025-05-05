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
        $this->actingAsUserWithSufficientBalance(function ($user) {
            $payload = $this->getOrderPayload('buy');

            $response = $this->postJson('fa/api/orders/store', $payload, [
                'X-User-ID' => $user->id,
            ]);

            $response->assertStatus(201); 

            $this->assertDatabaseHas('orders', [
                'user_id' => $user->id,
                'type' => 'buy',
                'amount' => $payload['amount'],
                'price_per_gram' => $payload['price_per_gram'],
            ]);
        });
    }


    public function test_user_cannot_store_buy_order_with_insufficient_balance()
    {
        $this->actingAsUserWithInsufficientBalance(function ($user) {
            $payload = $this->getOrderPayload('buy');

            $response = $this->postJson('fa/api/orders/store', $payload, [
                'X-User-ID' => $user->id,
            ]);

            $response->assertStatus(500);
            $this->assertDatabaseMissing('orders', [
                'user_id' => $user->id,
            ]);
        });
    }

    private function actingAsUserWithSufficientBalance($callback)
    {
        $faker = Faker::create();
        $user = User::factory()->create();

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => 1_000_000,
            'balance_gold' => 10,
        ]);

        $callback($user);
    }

    private function actingAsUserWithInsufficientBalance($callback)
    {
        $faker = Faker::create();
        $user = User::factory()->create();

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => 100_000,
            'balance_gold' => 0,
        ]);

        $callback($user);
    }

    private function getOrderPayload($type)
    {
        $faker = Faker::create();
        $amount = $faker->randomFloat(2, 1, 10);
        $pricePerGram = $faker->numberBetween(50_000, 200_000);

        return [
            'type' => $type,
            'amount' => $amount,
            'price_per_gram' => $pricePerGram,
        ];
    }
}
