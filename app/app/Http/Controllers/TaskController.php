<?php

namespace App\Http\Controllers;

use App\DataTables\Buttons\ActionButton;
use App\Datatables\TasksDataTable;
use App\DataTransferObjects\DatatablesFilterDto;
use App\DataTransferObjects\TaskDto;
use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Services\ProjectService;
use App\Services\TaskService;
use Illuminate\Http\Request;

class TaskController extends Controller
{
	public function __construct(
		protected TaskService    $service,
		protected ProjectService $projectService,
	)
	{
	}

	public function index(TasksDataTable $dataTable, Project $project)
	{
		$this->setPageTitle(__('task.plural'));

		return $dataTable
			->setProject($project)
			->addActionLink(new ActionButton([
				'title' => __('task.actions.create'),
				'html_class' => 'btn-primary',
				'icon' => 'bx bx-message-square-add',
				'url' => route('projects.tasks.create', $project),
			]))
			->render('contents.datatable');
	}

	public function datatables(Request $request, Project $project)
	{
		return $this->service->datatables(
			DatatablesFilterDto::fromRequest($request)
				->addParam('user_id', $request->user()->id)
				->addParam('project_id', $project->id),
		);
	}

	public function create(Request $request, Project $project)
	{
		abort_if(!$this->projectService->isOwner($request->user(), $project), 403);
		$this->setPageTitle(__('task.actions.create'));

		return view('contents.tasks.create', compact('project'));
	}

	public function store(TaskRequest $request, Project $project)
	{
		abort_if(!$this->projectService->isOwner($request->user(), $project), 403);

		if (!is_null($this->service->store($project, TaskDto::fromRequest($request)))) {
			return redirect(route('projects.tasks.create', $project))->with('success', __('task.sentences.store.success'));
		}

		return redirect()->back()->withInput()->withErrors(['message' => __('task.sentences.store.error')]);
	}

	public function edit(Request $request, Project $project, Task $task)
	{
		abort_if(!$this->service->isOwner($request->user(), $task), 403);
		$this->setPageTitle(__('task.actions.edit'));

		return view('contents.tasks.edit', compact('project', 'task'));
	}

	public function update(TaskRequest $request, Project $project, Task $task)
	{
		abort_if(!$this->service->isOwner($request->user(), $task), 403);

		if ($this->service->update($task, TaskDto::fromRequest($request))) {
			return redirect(route('projects.tasks.index', $project))->with('success', __('task.sentences.update.success'));
		}

		return redirect()->back()->withInput()->withErrors(['message' => __('task.sentences.update.error')]);
	}

	public function destroy(Request $request, Project $project, Task $task)
	{
		abort_if(boolean: !$this->service->isOwner($request->user(), $task), code: 403, headers: [
			'Content-Type' => 'application/json',
		]);

		if ($this->service->destroy($task)) {
			return response()->json([
				'message' => __('task.sentences.destroy.success'),
			]);
		}

		return response()->json([
			'message' => __('task.sentences.destroy.success'),
		], 400);
	}
}
