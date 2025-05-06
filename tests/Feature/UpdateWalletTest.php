<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateWalletTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_deposit_into_wallet()
    {
        $user = User::factory()->create();

        $payload = [
            'type' => 'deposit',
            'amount' => 100_000,
        ];

        $response = $this->putJson('fa/api/user/wallet/update', $payload, [
            'X-User-ID' => $user->id,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['message' => __('messages.wallet_updated')]);

        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance_toman' => 100_000,
        ]);
    }

    public function test_user_cannot_withdraw_more_than_balance()
    {
        $user = User::factory()->create();

        Wallet::factory()->create([
            'user_id' => $user->id,
            'balance_toman' => 50_000,
        ]);

        $payload = [
            'type' => 'withdraw',
            'amount' => 100_000,
        ];

        $response = $this->putJson('fa/api/user/wallet/update', $payload, [
            'X-User-ID' => $user->id,
        ]);

        $response->assertStatus(500);
        $this->assertDatabaseHas('wallets', [
            'user_id' => $user->id,
            'balance_toman' => 50_000,
        ]);
    }
}
