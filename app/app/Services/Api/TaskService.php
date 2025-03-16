<?php

namespace App\Services\Api;

use App\DataTransferObjects\Api\TaskDto;
use App\Exceptions\Api\ApiNotFound;
use App\Exceptions\Api\OwnerException;
use App\Models\Project;
use App\Models\Task;

class TaskService
{
	/**
	 * @param int $userId
	 * @param int $limit
	 * @param int $offset
	 * @return Task[]
	 */
	public function list(int $userId, int $limit = 30, int $offset = 0)
	{
		return Task::whereUserId($userId)
			->with('project')
			->latest('created_at')
			->skip($offset)
			->take($limit)
			->get();
	}


	/**
	 * @param int $userId
	 * @param int $taskId
	 * @return bool
	 * @throws OwnerException
	 * @throws ApiNotFound
	 */
	public function markAsCompleted(int $userId, int $taskId): bool
	{
		$task = Task::find($taskId);
		if (is_null($task)) {
			throw new ApiNotFound(__('task.validations.not_found'));
		}

		if ($task->user_id !== $userId) {
			throw new OwnerException(__('task.validations.forbidden'));
		}

		return $task->update(['status' => 'complete']);
	}


	/**
	 * @param int $userId
	 * @param int $taskId
	 * @return bool|null
	 * @throws OwnerException
	 * @throws ApiNotFound
	 */
	public function destroy(int $userId, int $taskId): ?bool
	{
		$task = Task::find($taskId);
		if (is_null($task)) {
			throw new ApiNotFound(__('task.validations.not_found'));
		}

		if ($task->user_id !== $userId) {
			throw new OwnerException(__('task.validations.forbidden'));
		}

		return $task->delete();
	}

	/**
	 * @param TaskDto $dto
	 * @return Task
	 * @throws ApiNotFound
	 * @throws OwnerException
	 */
	public function store(TaskDto $dto): Task
	{
		$project = Project::find($dto->getProjectId());
		if (is_null($project)) {
			throw new ApiNotFound(__('project.validations.not_found'));
		}

		if ($project->user_id !== $dto->getUserId()) {
			throw new OwnerException(__('project.validations.forbidden'));
		}

		return Task::create($dto->toArray());
	}
}