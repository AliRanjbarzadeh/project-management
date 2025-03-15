<?php

namespace App\DataTransferObjects;

use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Hash;

class RegisterDto
{
	public function __construct(
		private string $fullName,
		private string $email,
		private string $username,
		private string $password,
	)
	{
	}

	public static function fromRequest(RegisterRequest $request): static
	{
		return new self(
			fullName: $request->input('full_name'),
			email: $request->input('email'),
			username: $request->input('username'),
			password: $request->input('password'),
		);
	}

	public function toArray(): array
	{
		return [
			'full_name' => $this->fullName,
			'email' => $this->email,
			'username' => $this->username,
			'password' => Hash::make($this->password),
		];
	}
}