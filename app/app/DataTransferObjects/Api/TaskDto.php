<?php

namespace App\DataTransferObjects\Api;

use App\Http\Requests\Api\TaskRequest;

class TaskDto
{
	public function __construct(
		private int     $userId,
		private int     $projectId,
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
			projectId: $request->input('project_id'),
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
			'project_id' => $this->projectId,
			'title' => $this->title,
			'description' => $this->description,
			'priority' => $this->priority,
			'status' => 'incomplete',
		];

		if (!is_null($this->dueDate)) {
			$data['due_date'] = $this->dueDate;
		}
		if (!is_null($this->deadline)) {
			$data['deadline'] = $this->deadline;
		}

		return $data;
	}

	/**
	 * @return int
	 */
	public function getUserId(): int
	{
		return $this->userId;
	}

	/**
	 * @return int
	 */
	public function getProjectId(): int
	{
		return $this->projectId;
	}
}