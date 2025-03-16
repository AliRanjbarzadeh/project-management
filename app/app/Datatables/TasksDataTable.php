<?php

namespace App\Datatables;

use App\Models\Project;
use App\Models\Task;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class TasksDataTable extends BaseDataTable
{
	private Project $project;

	public function __construct()
	{
		parent::__construct();

		$this->attributes['has_priority'] = false;
		$this->attributes['exportable'] = false;
		$this->attributes['model_name'] = Task::class;

		$this->addDropDown('status', $this->getStatuses());
		$this->addDropDown('priority', $this->getPriorities());
	}

	public function setProject(Project $project): static
	{
		$this->project = $project;
		return $this;
	}

	public function html(): HtmlBuilder
	{
		return parent::html()
			->setTableId('tasks-datatables')
			->ajax([
				'url' => route('projects.tasks.datatables', $this->project),
				'type' => 'post',
				'data' => 'function(d) {
					if (typeof addFiltersToData === "function") {
						addFiltersToData(d);
					}
				}',
			])
			->orderBy(6);
	}

	public function getColumns(): array
	{
		return [
			Column::make('loop_iterator')
				->title(__('global.fields.index'))
				->responsivePriority(0)
				->width(20)
				->orderable(false)
				->searchable(false),

			Column::make('title')
				->title(__('task.fields.title'))
				->responsivePriority(1)
				->orderable(false)
				->exportable()
				->printable()
				->type('text'),

			Column::make('priority_drop_down', 'priority')
				->title(__('task.fields.priority'))
				->responsivePriority(1)
				->orderable(false)
				->exportable()
				->printable()
				->searchable()
				->type('dropdown'),

			Column::make('status_drop_down', 'status')
				->title(__('task.fields.status'))
				->responsivePriority(1)
				->orderable(false)
				->exportable()
				->printable()
				->searchable()
				->type('dropdown'),

			Column::make('due_date_jalali', 'due_date')
				->title(__('task.fields.due_date'))
				->orderable()
				->exportable()
				->printable()
				->type('date'),

			Column::make('deadline_jalali', 'deadline')
				->title(__('task.fields.deadline'))
				->orderable()
				->exportable()
				->printable()
				->type('date'),

			Column::make('created_at_jalali', 'created_at')
				->title(__('global.fields.created_at'))
				->orderable()
				->exportable()
				->printable()
				->type('date'),

			Column::make('action')
				->title(__('global.fields.tools'))
				->responsivePriority(1)
				->orderable(false)
				->printable(false)
				->exportable(false)
				->searchable(false),
		];
	}

	private function getStatuses(): array
	{
		return [
			'complete' => __('task.statuses.complete'),
			'incomplete' => __('task.statuses.incomplete'),
		];
	}

	private function getPriorities(): array
	{
		return [
			'low' => __('task.priorities.low'),
			'medium' => __('task.priorities.medium'),
			'high' => __('task.priorities.high'),
		];
	}
}