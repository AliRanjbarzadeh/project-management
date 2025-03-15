<?php

namespace App\Services;

use App\DataTransferObjects\DatatablesFilterDto;
use App\DataTransferObjects\ProjectDto;
use App\Models\Project;

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
			->regexpSearch(term: $dto->getValue('title'), columns: 'title')
			->dateRangeSearch(fromDate: $dto->getValue('from_created_at'), toDate: $dto->getValue('to_created_at'));

		return $this->datatablesService
			->setHasPriority(false)
			->setModule("projects")
			->build($projects)
			->toJson();
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