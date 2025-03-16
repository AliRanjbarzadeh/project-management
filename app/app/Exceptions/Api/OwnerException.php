<?php

namespace App\Exceptions\Api;

use App\Enums\HttpStatusEnum;
use Exception;

class OwnerException extends Exception
{
	public function render()
	{
		return response()->json([
			'message' => $this->message,
		], HttpStatusEnum::FORBIDDEN);
	}
}
