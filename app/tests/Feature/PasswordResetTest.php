<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_request_password_reset()
	{
		$this->withSession([]);

		$user = User::factory()->create(['email' => 'test@example.com']);

		$response = $this->post(route('login.forgot-password.attempt'), [
			'email' => 'test@example.com',
		]);

		$response->assertSessionHas('success');

		$this->assertDatabaseHas('password_reset_tokens', [
			'email' => 'test@example.com',
		]);
	}

	public function test_user_can_reset_password()
	{
		$this->withSession([]);

		$user = User::factory()->create(['email' => 'test@example.com']);

		// Create a reset token
		$token = Password::createToken($user);

		$response = $this->post(route('reset-password.attempt'), [
			'email' => 'test@example.com',
			'password' => 'newpassword123',
			'password_confirmation' => 'newpassword123',
			'token' => $token,
		]);

		$response->assertRedirect(route('login'));

		// Verify password is updated
		$this->assertTrue(Hash::check('newpassword123', $user->fresh()->password));
	}

	public function test_password_reset_fails_with_invalid_token()
	{
		$this->withSession([]);

		$user = User::factory()->create(['email' => 'test@example.com']);

		$response = $this->post(route('reset-password.attempt'), [
			'email' => 'test@example.com',
			'password' => 'newpassword123',
			'password_confirmation' => 'newpassword123',
			'token' => 'invalid-token',
		]);

		$response->assertSessionHasErrors('message');
	}
}
