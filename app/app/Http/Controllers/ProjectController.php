<?php

namespace App\Http\Controllers;

use App\Datatables\ProjectsDataTable;
use App\DataTransferObjects\DatatablesFilterDto;
use App\DataTransferObjects\ProjectDto;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
	public function __construct(
		protected ProjectService $service,
	)
	{
	}

	public function index(ProjectsDataTable $dataTable)
	{
		return $dataTable->render('contents.datatable');
	}

	public function datatables(Request $request)
	{
		return $this->service->datatables(DatatablesFilterDto::fromRequest($request));
	}

	public function create()
	{
		return view('contents.projects.create');
	}

	public function store(ProjectRequest $request)
	{
		if (!is_null($this->service->store(ProjectDto::fromRequest($request)))) {
			return redirect(route('projects.create'))->with('success', __('project.sentences.store.success'));
		}

		return redirect()->back()->withInput()->withErrors(['message' => __('project.sentences.store.error')]);
	}

	public function edit(Project $project)
	{
		return view('contents.projects.edit', compact('project'));
	}

	public function update(ProjectRequest $request, Project $project)
	{
		if ($this->service->update($project, ProjectDto::fromRequest($request))) {
			return redirect(route('projects.index'))->with('success', __('project.sentences.update.success'));
		}

		return redirect()->back()->withInput()->withErrors(['message' => __('project.sentences.update.error')]);
	}

	public function destroy(Project $project)
	{
		if ($this->service->destroy($project)) {
			return response()->json([
				'message' => __('project.sentences.destroy.success'),
			]);
		}

		return response()->json([
			'message' => __('project.sentences.destroy.success'),
		], 400);
	}
}
