<?php

namespace App\DataTransferObjects;

use Illuminate\Http\Request;

class DatatablesFilterDto
{
	public function __construct(
		public array $params = [],
	)
	{
	}

	public static function fromRequest(Request $request): static
	{
		return new self($request->toArray());
	}

	public function addParam(string $key, mixed $value): static
	{
		$this->params[$key] = $value;
		return $this;
	}

	public function getValue(string $key): mixed
	{
		return $this->params[$key] ?? null;
	}
}