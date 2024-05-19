<?php

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use DatabaseMigrations;

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
        ]);

        $response->assertRedirect(route('home')); // Redirect ke halaman beranda setelah login berhasil
        $this->assertAuthenticatedAs($user); // Pastikan pengguna telah diautentikasi
    }

    /** @test */
    public function user_cannot_login_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'test@example.com',
            'password' => 'wrong_password', // Password salah
        ]);

        $response->assertSessionHasErrors(); // Pastikan ada pesan kesalahan sesi
        $this->assertGuest(); // Pastikan pengguna tidak diautentikasi
    }

    /** @test */
    public function user_cannot_login_with_invalid_email()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'wrong@example.com', // Email salah
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(); // Pastikan ada pesan kesalahan sesi
        $this->assertGuest(); // Pastikan pengguna tidak diautentikasi
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->actingAs($user); // Masukkan pengguna

        $response = $this->post('/logout');

        $response->assertRedirect('/'); // Redirect ke halaman beranda setelah logout berhasil
        $this->assertGuest(); // Pastikan pengguna tidak diautentikasi
    }
}
