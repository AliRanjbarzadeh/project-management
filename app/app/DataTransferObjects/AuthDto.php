<?php

namespace App\DataTransferObjects;

use App\Http\Requests\AuthRequest;

class AuthDto
{
	public function __construct(
		public string $username,
		public string $password,
		public bool   $remember,
	)
	{
	}

	public static function fromRequest(AuthRequest $request): static
	{
		return new self(
			username: $request->input('username'),
			password: $request->input('password'),
			remember: $request->input('remember'),
		);
	}

	public function toArray(): array
	{
		$loginField = filter_var($this->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

		return [
			$loginField => $this->username,
			'password' => $this->password,
		];
	}
}