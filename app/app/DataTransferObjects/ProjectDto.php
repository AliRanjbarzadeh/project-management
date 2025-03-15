<?php

namespace App\DataTransferObjects;

use App\Http\Requests\ProjectRequest;

class ProjectDto
{
	public function __construct(
		private int     $userId,
		private string  $title,
		private ?string $description,
	)
	{
	}

	public static function fromRequest(ProjectRequest $request): static
	{
		return new self(
			userId: $request->user()->id,
			title: $request->input('title'),
			description: $request->input('description'),
		);
	}

	public function toArray(): array
	{
		return [
			'user_id' => $this->userId,
			'title' => $this->title,
			'description' => $this->description,
		];
	}
}