<?php

namespace App\Http\Resources\Api;

use App\Enums\HttpStatusEnum;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidationErrorResource extends JsonResource
{
	public static $wrap = null;

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			"message" => $this->errors()->first(),
			'errors' => $this->errors(),
		];
	}

	public function withResponse(Request $request, JsonResponse $response)
	{
		$response->setStatusCode(HttpStatusEnum::VALIDATION);
	}
}
