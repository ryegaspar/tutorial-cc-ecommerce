<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MeTest extends TestCase
{
    /** @test */
    public function it_fails_if_user_isnt_authenticated()
    {
        $this->json('GET', 'api/auth/me')
            ->assertStatus(401);
    }

    /** @test */
    public function it_returns_user_details()
    {
        $user = factory(User::class)->create();

        $this->jsonAs($user, 'GET', 'api/auth/me')
            ->assertJsonFragment([
                'email' => $user->email
            ]);
    }
}
