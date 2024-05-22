<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use DatabaseMigrations; // Refresh the database for each test

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'password',
            '_token' => csrf_token(), // Include CSRF token
        ]);

        $response->assertRedirect(route('home')); 
        $this->assertAuthenticatedAs($user); 
    }

    /** @test */
    public function user_cannot_login_with_invalid_password()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
            '_token' => csrf_token(), // Include CSRF token
        ]);

        $response->assertSessionHasErrors(); 
        $this->assertGuest(); 
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->withSession(['errors' => new \Illuminate\Support\MessageBag]) 
            ->post(route('login'), [
                'email' => 'wrong@example.com',
                'password' => 'password',
                '_token' => csrf_token(), // Include CSRF token
            ]);

        $response->assertSessionHasErrors();
        $this->assertGuest(); 
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');

        $response->assertRedirect('/'); 
        $this->assertGuest(); 
    }
}
