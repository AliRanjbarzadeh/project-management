<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
	use RefreshDatabase;

	public function test_user_can_request_password_reset_with_email()
	{
		Notification::fake();

		$this->withMiddleware();
		$user = User::factory()->create([
			'email' => 'ranjbarzadehali@gmail.com',
		]);

		$response = $this->withSession([])->post(route('login.forgot-password.attempt'), [
			'email' => 'ranjbarzadehali@gmail.com',
		]);

		$response->assertSessionHas('success');

		Notification::assertSentTo([$user], ResetPasswordNotification::class);
	}

	public function test_non_existent_user_cannot_request_password_reset()
	{
		$response = $this->withSession([])->post(route('login.forgot-password.attempt'), [
			'email' => 'nonexistentuser@exmaple.com',
		]);

		$response->assertSessionHasErrors('email');
	}
}
