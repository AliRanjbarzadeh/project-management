<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
	use RefreshDatabase;

	public function test_dashboard_is_not_accessible_without_login(): void
	{
		$response = $this->get('/');

		$response->assertRedirect('/login'); // Expect a redirect to login
	}

	public function test_dashboard_is_accessible_with_login(): void
	{
		$user = User::factory()->create(); // Create a test user

		$response = $this->actingAs($user)->get('/');

		$response->assertStatus(200);
	}

	public function test_auth_fails_when_username_is_missing()
	{
		$response = $this->withSession([])->post(route('login.attempt'), [
			'password' => 'password123',
			'remember' => true,
		]);

		$response->assertSessionHasErrors(['username']);
	}

	public function test_auth_fails_when_password_is_missing()
	{
		$response = $this->withSession([])->post(route('login.attempt'), [
			'username' => 'testuser',
			'remember' => true,
		]);

		$response->assertSessionHasErrors(['password']);
	}

	public function test_auth_fails_when_both_fields_are_missing()
	{
		$response = $this->withSession([])->post(route('login.attempt'), []);

		$response->assertSessionHasErrors(['username', 'password']);
	}

	public function test_auth_succeeds_with_valid_data()
	{
		User::factory()->create([
			'username' => 'testuser',
			'email' => 'test@example.com',
			'password' => bcrypt('password123'),
		]);

		$response = $this->withSession([])->post(route('login.attempt'), [
			'username' => 'testuser',
			'password' => 'password123',
			'remember' => true,
		]);

		$response->assertRedirect(route('index'));
	}
}
