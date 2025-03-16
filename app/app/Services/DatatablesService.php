<?php

namespace App\Services;

use App\DataTables\Buttons\ToolButton;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\EloquentDatatable;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Facades\DataTables;

class DatatablesService
{
	private bool $hasPriority = false;
	private array $defaultActions = ['edit', 'destroy'];
	private EloquentDatatable $datatable;
	private string $moduleName;

	/**
	 * Used for each row in table
	 * @var array|ToolButton[]
	 */
	private array $actions;

	/**
	 * Extra url params before model param used before model in url
	 * @var array
	 */
	private array $params = [];

	/**
	 * Set route name (for example: projects, projects.tasks and ...)
	 * @param string $moduleName
	 * @return $this
	 */
	public function setModule(string $moduleName): static
	{
		$this->moduleName = $moduleName;
		return $this;
	}

	/**
	 * @param bool $hasPriority
	 * @return DatatablesService
	 */
	public function setHasPriority(bool $hasPriority): static
	{
		$this->hasPriority = $hasPriority;
		return $this;
	}

	/**
	 * With this method you can limit default actions to show for each row in table (edit, destroy are defaults actions)
	 * @param array $defaultActions
	 * @return $this
	 */
	public function setDefaultActions(array $defaultActions): static
	{
		$this->defaultActions = $defaultActions;
		return $this;
	}

	/**
	 * Add extra param
	 * @param int|string $param
	 * @return $this
	 */
	public function addParam(int|string $param): static
	{
		$this->params[] = $param;
		return $this;
	}

	/**
	 * Add extra action button (shows for each row)
	 * @param ToolButton $button
	 * @return $this
	 */
	public function addAction(ToolButton $button): static
	{
		$this->actions[] = $button;
		return $this;
	}

	/**
	 * Build datatable
	 *
	 * @param $query
	 * @return EloquentDatatable
	 * @throws Exception
	 */
	public function build($query): EloquentDatatable
	{
		//Make instance
		$this->makeDatatable($query);

		//Render priority
		$this->renderPriority();

		//Render actions
		$this->renderActions();

		return $this->datatable;
	}

	/**
	 * Make base datatable
	 * @param $query
	 * @return void
	 * @throws \Yajra\DataTables\Exceptions\Exception
	 */
	private function makeDatatable($query): void
	{
		$this->datatable = DataTables::eloquent($query)
			->addIndexColumn()
			->setRowId('id');
	}

	/**
	 * Render priority column
	 * @return void
	 */
	private function renderPriority(): void
	{
		if ($this->hasPriority) {
			$this->datatable->orderColumn('priority', function ($query, $order) {
				$query->orderBy('priority', $order)
					->orderBy('id', 'desc');
			});

			$this->datatable->addColumn('priority', function (Model $model) {
				return view('datatables::priority', compact('model'))->render();
			});
		}
	}

	/**
	 * Render action buttons
	 * @return void
	 */
	private function renderActions(): void
	{
		$this->makeDefaultActions();
		$this->datatable->addColumn('action', function (Model $model) {
			//Prepare route params
			$params = array_merge($this->params, [$model->id]);

			$actions = $this->actions;

			return view('datatables::actions', compact('actions', 'model', 'params'));
		});
	}

	/**
	 * Add default actions based on user selected
	 * @return void
	 */
	private function makeDefaultActions(): void
	{
		if (in_array('edit', $this->defaultActions, true)) {
			$this->actions[] = new ToolButton([
				'title' => __('global.fields.edit'),
				'url' => "$this->moduleName.edit",
				'icon' => 'bx bx-edit-alt',
			]);
		}

		if (in_array('destroy', $this->defaultActions, true)) {
			$this->actions[] = new ToolButton([
				'title' => __('global.actions.delete'),
				'url' => "$this->moduleName.destroy",
				'icon' => 'bx bx-trash text-danger',
			], true, 'deleteItem(this);');
		}
	}
}