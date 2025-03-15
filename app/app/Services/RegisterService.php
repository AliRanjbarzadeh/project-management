<?php

namespace App\Services;

use App\DataTransferObjects\RegisterDto;
use App\Models\User;

class RegisterService
{
	public function register(RegisterDto $dto): ?User
	{
		return User::create($dto->toArray());
	}
}