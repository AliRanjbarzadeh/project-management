<?php

namespace App\Services;

use App\DataTables\Buttons\ToolButton;
use App\DataTransferObjects\DatatablesFilterDto;
use App\DataTransferObjects\ProjectDto;
use App\Models\Project;
use App\Models\User;

class ProjectService
{
	public function __construct(
		protected DatatablesService $datatablesService,
	)
	{
	}

	public function datatables(DatatablesFilterDto $dto)
	{
		$projects = Project::query()
			->whereUserId($dto->getValue('user_id'))
			->termSearch(term: $dto->getValue('title'), columns: 'title')
			->dateRangeSearch(fromDate: $dto->getValue('from_created_at'), toDate: $dto->getValue('to_created_at'));

		return $this->datatablesService
			->setHasPriority(false)
			->setModule("projects")
			->addAction(new ToolButton([
				'title' => __('task.plural'),
				'url' => 'projects.tasks.index',
				'icon' => 'bx bx-package',
			]))
			->build($projects)
			->toJson();
	}

	public function isOwner(User $user, Project $project): bool
	{
		return $user->id === $project->user_id;
	}

	public function store(ProjectDto $dto): ?Project
	{
		return Project::create($dto->toArray());
	}

	public function update(Project $project, ProjectDto $dto): bool
	{
		return $project->update($dto->toArray());
	}

	public function destroy(Project $project): bool
	{
		return $project->delete();
	}
}