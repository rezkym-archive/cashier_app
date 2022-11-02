<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Features;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user can confirm their password before continuing
     *
     * @return Tests\TestCase\assertStatus 200
     */
    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $response = $this->actingAs($user)->get('/user/confirm-password');

        $response->assertStatus(200);
    }

    /**
     * Test that a user can confirm their password
     *
     * @return Tests\TestCase\assertRedirect
     * @return Tests\TestCase\aassertSessionHasNoErrors
     */
    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/user/confirm-password', [
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test that a user cannot confirm their password with invalid password
     *
     * @return Tests\TestCase\assertSessionHasErrors
     */
    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/user/confirm-password', [
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors();
    }
}
