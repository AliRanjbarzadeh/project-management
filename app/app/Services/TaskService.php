<?php

namespace App\Services;

use App\DataTransferObjects\DatatablesFilterDto;
use App\DataTransferObjects\TaskDto;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class TaskService
{
	public function __construct(
		protected DatatablesService $datatablesService,
	)
	{
	}

	public function datatables(DatatablesFilterDto $dto)
	{
		$tasks = Task::query()
			->whereUserId($dto->getValue('user_id'))
			->whereProjectId($dto->getValue('project_id'))
			->termSearch(term: $dto->getValue('title'), columns: 'title')
			->dateRangeSearch(fromDate: $dto->getValue('from_created_at'), toDate: $dto->getValue('to_created_at'));

		return $this->datatablesService
			->setHasPriority(false)
			->setModule("projects.tasks")
			->addParam($dto->getValue('project_id'))
			->build($tasks)
			->toJson();
	}

	public function isOwner(User $user, Task $task): bool
	{
		return $user->id === $task->user_id;
	}

	public function store(Project $project, TaskDto $dto): ?Task
	{
		return $project->tasks()->create($dto->toArray());
	}

	public function update(Task $task, TaskDto $dto): bool
	{
		return $task->update($dto->toArray());
	}

	public function destroy(Task $task): bool
	{
		return $task->delete();
	}
}