<?php

namespace App\DataTransferObjects;

use App\Http\Requests\TaskRequest;

class TaskDto
{
	public function __construct(
		private int     $userId,
		private string  $title,
		private ?string $description,
		private string  $priority,
		private ?string $dueDate,
		private ?string $deadline,
	)
	{
	}

	public static function fromRequest(TaskRequest $request): static
	{
		return new self(
			userId: $request->user()->id,
			title: $request->input('title'),
			description: $request->input('description'),
			priority: $request->input('priority'),
			dueDate: $request->input('due_date'),
			deadline: $request->input('deadline'),
		);
	}

	public function toArray(): array
	{
		$data = [
			'user_id' => $this->userId,
			'title' => $this->title,
			'description' => $this->description,
			'priority' => $this->priority,
		];

		if (!is_null($this->dueDate)) {
			$data['due_date'] = $this->dueDate;
		}
		if (!is_null($this->deadline)) {
			$data['deadline'] = $this->deadline;
		}

		return $data;
	}
}