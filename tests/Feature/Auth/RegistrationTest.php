<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    /** @test */
    public function it_requires_a_name()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_requires_an_email()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_requires_a_valid_email()
    {
        $this->json('POST', 'api/auth/register', [
            'email' => 'nope'
        ])
            ->assertJsonValidationErrors(['email']);
    }

    /** @test */
    public function it_requires_a_unique_valid_email()
    {
        $user = factory(User::class)->create();

        $this->json('POST', 'api/auth/register', [
            'email' => $user->email
        ])
            ->assertJsonValidationErrors(['name']);
    }

    /** @test */
    public function it_requires_a_password()
    {
        $this->json('POST', 'api/auth/register')
            ->assertJsonValidationErrors(['password']);
    }

    /** @test */
    public function it_registers_a_user()
    {
        $this->json('POST', 'api/auth/register', [
            'name'     => $name = 'John',
            'email'    => $email = 'john@example.com',
            'password' => 'secret'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name'  => $name
        ]);
    }

    /** @test */
    public function it_returns_a_user_on_registration()
    {
        $this->json('POST', 'api/auth/register', [
            'name'     => 'John',
            'email'    => $email = 'john@example.com',
            'password' => 'secret'
        ])
            ->assertJsonFragment([
                'email' => $email
            ]);
    }
}
