<?php

namespace App\Exceptions\Api;

use App\Enums\HttpStatusEnum;
use Exception;
use Illuminate\Http\JsonResponse;

class ApiNotFound extends Exception
{
	public function render(): JsonResponse
	{
		return response()->json([
			'message' => $this->message,
		], HttpStatusEnum::NOT_FOUND);
	}
}
