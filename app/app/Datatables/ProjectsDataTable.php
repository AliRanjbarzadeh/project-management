<?php

namespace App\Datatables;

use App\Models\Project;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;

class ProjectsDataTable extends BaseDataTable
{
	public function __construct()
	{
		parent::__construct();

		$this->attributes['has_priority'] = false;
		$this->attributes['exportable'] = false;
		$this->attributes['model_name'] = Project::class;
	}

	public function html(): HtmlBuilder
	{
		return parent::html()
			->setTableId('consultantTable')
			->ajax([
				'url' => route('projects.datatables'),
				'type' => 'post',
				'data' => 'function(d) {
					if (typeof addFiltersToData === "function") {
						addFiltersToData(d);
					}
				}',
			])
			->orderBy(2);
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
				->title(__('project.fields.title'))
				->responsivePriority(1)
				->orderable(false)
				->exportable()
				->printable()
				->type('text'),

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
}