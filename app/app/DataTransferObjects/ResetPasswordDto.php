<?php

namespace App\DataTransferObjects;

use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordDto
{
	public function __construct(
		private string $email,
		private string $password,
		private string $passwordConfirmation,
		private string $token,
	)
	{
	}

	public static function fromRequest(ResetPasswordRequest $request): static
	{
		return new self(
			email: $request->input('email'),
			password: $request->input('password'),
			passwordConfirmation: $request->input('password_confirmation'),
			token: $request->input('token'),
		);
	}

	public function toArray(): array
	{
		return [
			'email' => $this->email,
			'password' => $this->password,
			'password_confirmation' => $this->passwordConfirmation,
			'token' => $this->token,
		];
	}
}