<?php

namespace App\Services;

use App\DataTransferObjects\ResetPasswordDto;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthService
{
	/**
	 * Find a user by email or username.
	 */
	public function findUserByEmailOrUsername(string $identifier): ?User
	{
		return User::where('email', $identifier)
			->orWhere('username', $identifier)
			->first();
	}

	/**
	 * Send a forgot password request.
	 */
	public function sendForgotPasswordRequest(string $identifier): bool
	{
		$user = $this->findUserByEmailOrUsername($identifier);

		if (!$user) {
			return false;
		}

		// Send password reset link using Laravel's Password Broker
		$status = Password::sendResetLink(['email' => $user->email]);

		return $status === Password::RESET_LINK_SENT;
	}

	/**
	 * Reset password using token.
	 */
	public function resetPassword(ResetPasswordDto $dto): bool
	{
		$status = Password::reset($dto->toArray(), function (User $user, string $password) {
			$user->forceFill([
				'password' => Hash::make($password),
				'remember_token' => Str::random(60),
			])->save();

			event(new PasswordReset($user));
		});

		return $status === Password::PASSWORD_RESET;
	}
}