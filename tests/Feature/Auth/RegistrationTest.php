<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;
use Tests\TestCase;
use App\Models\User;
use Spatie\Permission\Models\Role;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test_registration_screen_can_be_rendered
     *
     * This test will be rendered if the user is not logged in
     *
     * @return 200
     *
     */
    public function test_registration_screen_can_be_rendered()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * test_registration_screen_cannot_be_rendered_if_support_is_disabled
     *
     * Registration screen will be not rendered when the feature is disabled
     *
     * @return 404
     */
    public function test_registration_screen_cannot_be_rendered_if_support_is_disabled()
    {
        if (Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is enabled.');
        }

        $response = $this->get('/register');

        $response->assertStatus(404);
    }


    /**
     * test_new_users_can_register
     *
     * This test will check the user can be register
     * using dump account
     *
     * @return 200
     */
    public function test_new_users_can_register()
    {
        if (! Features::enabled(Features::registration())) {
            return $this->markTestSkipped('Registration support is not enabled.');
        }

        // Create random role
        Role::create(['name' => 'cashier']);

        // Create random user using faker
        $user = User::factory()->create();

        // assign user to cashier role
        $user->assignRole('cashier');

        // Create new user
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'demo@demo.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature(),
        ]);

        // Check if the user is authenticated
        $this->assertAuthenticated();

        // If the user is authenticated, redirect to home
        $response->assertRedirect(RouteServiceProvider::HOME);
    }
}
