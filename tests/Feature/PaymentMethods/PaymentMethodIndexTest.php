<?php

namespace Tests\Feature\PaymentMethods;

use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentMethodIndexTest extends TestCase
{
    /** @test */
    public function it_fails_if_not_authenticated()
    {
        $this->json('GET', 'api/payment-methods')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_a_collection_of_payment_methods()
    {
        $user = factory(User::class)->create();

        $paymentMethod = factory(PaymentMethod::class)->create([
            'user_id' => $user->id
        ]);

        $this->jsonAs($user, 'GET', 'api/payment-methods')
            ->assertJsonFragment([
                'id' => $paymentMethod->id
            ]);
    }
}
