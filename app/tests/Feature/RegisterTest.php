<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_register_successfully()
	{
		$this->withSession([]);

		$response = $this->post(route('register.attempt'), [
			'full_name' => 'Test User',
			'username' => 'testuser',
			'email' => 'test@example.com',
			'password' => 'password123',
			'password_confirmation' => 'password123',
		]);

		$response->assertSessionHas('success');
		$response->assertRedirect(route('index'));
		$this->assertDatabaseHas('users', ['email' => 'test@example.com']);
		$this->assertAuthenticated();
	}

	public function test_registration_fails_if_username_already_taken()
	{
		$this->withSession([]);

		User::factory()->create(['username' => 'testuser']);

		$response = $this->post(route('register.attempt'), [
			'full_name' => 'Test User',
			'username' => 'testuser', // Duplicate username
			'email' => 'test@example.com',
			'password' => 'password123',
			'password_confirmation' => 'password123',
			'terms' => '1',
		]);

		$response->assertSessionHasErrors('username');
	}

	public function test_registration_fails_if_email_already_taken()
	{
		$this->withSession([]);

		User::factory()->create(['email' => 'test@example.com']);

		$response = $this->post(route('register.attempt'), [
			'full_name' => 'Test User',
			'username' => 'testuser', // Duplicate username
			'email' => 'test@example.com',
			'password' => 'password123',
			'password_confirmation' => 'password123',
			'terms' => '1',
		]);

		$response->assertSessionHasErrors('email');
	}

	public function test_registration_fails_with_invalid_email()
	{
		$this->withSession([]);

		$response = $this->post(route('register.attempt'), [
			'full_name' => 'Test User',
			'username' => 'testuser',
			'email' => 'invalid-email', // Invalid email format
			'password' => 'password123',
			'password_confirmation' => 'password123',
			'terms' => '1',
		]);

		$response->assertSessionHasErrors('email');
	}

	public function test_registration_fails_with_short_password()
	{
		$this->withSession([]);

		$response = $this->post(route('register.attempt'), [
			'full_name' => 'Test User',
			'username' => 'testuser',
			'email' => 'test@example.com',
			'password' => '12345', // Too short
			'password_confirmation' => '12345',
			'terms' => '1',
		]);

		$response->assertSessionHasErrors('password');
	}
}
