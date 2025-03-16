<?php

namespace App\Services\Api;

use App\Models\Project;

class ProjectService
{
	/**
	 * @param int $userId
	 * @param int $limit
	 * @param int $offset
	 * @return Project[]
	 */
	public function list(int $userId, int $limit = 30, int $offset = 0)
	{
		return Project::whereUserId($userId)
			->latest('created_at')
			->skip($offset)
			->take($limit)
			->get();
	}

}