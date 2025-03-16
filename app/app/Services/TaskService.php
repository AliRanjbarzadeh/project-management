<?php

namespace App\Services;

use App\DataTransferObjects\DatatablesFilterDto;
use App\DataTransferObjects\TaskDto;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class TaskService
{
	public function __construct(
		protected DatatablesService $datatablesService,
	)
	{
	}

	public function datatables(DatatablesFilterDto $dto): JsonResponse
	{
		$tasks = Task::query()
			->whereUserId($dto->getValue('user_id'))
			->whereProjectId($dto->getValue('project_id'))
			->termSearch(term: $dto->getValue('title'), columns: 'title')
			->dateRangeSearch(column: 'created_at', fromDate: $dto->getValue('from_created_at'), toDate: $dto->getValue('to_created_at'))
			->dateRangeSearch(column: 'due_date', fromDate: $dto->getValue('from_due_date'), toDate: $dto->getValue('to_due_date'))
			->dateRangeSearch(column: 'deadline', fromDate: $dto->getValue('from_deadline'), toDate: $dto->getValue('to_deadline'))
			->customColumnSearch(column: 'status', operator: '=', value: $dto->getValue('status'))
			->customColumnSearch(column: 'priority', operator: '=', value: $dto->getValue('priority'));

		return $this->datatablesService
			->setHasPriority(false)
			->setModule("projects.tasks")
			->addParam($dto->getValue('project_id'))
			->build($tasks)
			->addColumn('priority_drop_down', function (Task $task) {
				return $task->priority_drop_down;
			})
			->addColumn('status_drop_down', function (Task $task) {
				return $task->status_drop_down;
			})
			->rawColumns(['priority_drop_down', 'status_drop_down'], true)
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

	public function changePriority(Task $task, string $priority): bool
	{
		return $task->update([
			'priority' => $priority,
		]);
	}

	public function changeStatus(Task $task, string $status): bool
	{
		return $task->update([
			'status' => $status,
		]);
	}
}