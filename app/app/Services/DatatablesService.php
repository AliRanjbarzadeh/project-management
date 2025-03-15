<?php

namespace App\Services;

use App\DataTables\Buttons\ToolButton;
use App\Helpers\General;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Yajra\DataTables\EloquentDatatable;
use Yajra\DataTables\Facades\DataTables;

class DatatablesService
{
	private bool $hasPriority = false;
	private bool $hasTranslate = false;
	private array $defaultActions = ['edit', 'destroy'];
	private EloquentDatatable $datatable;
	private string $moduleName;

	/**
	 * @var array|ToolButton[]
	 */
	private array $actions;

	private array $params = [];

	/**
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

	public function setHasTranslate(bool $hasTranslate): static
	{
		$this->hasTranslate = $hasTranslate;
		return $this;
	}

	public function setDefaultActions(array $defaultActions): static
	{
		$this->defaultActions = $defaultActions;
		return $this;
	}

	public function addParam(int|string $param): static
	{
		$this->params[] = $param;
		return $this;
	}

	public function addAction(ToolButton $button): static
	{
		$this->actions[] = $button;
		return $this;
	}

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

	private function makeDatatable($query): void
	{
		$this->datatable = DataTables::eloquent($query)
			->addIndexColumn()
			->setRowId('id');
	}

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

	private function renderActions(): void
	{
		$this->makeDefaultActions();
		$this->datatable->addColumn('action', function (Model $model) {
			//Prepare route params
			$params = array_merge($this->params, [$model->id]);

			$actions = $this->actions;

			$languages = General::getAvailableLanguages([app()->getLocale()]);

			$translationRoute = null;
			if ($this->hasTranslate) {
				if (Route::has("admin.$this->moduleName.translate.create")) {
					$translationRoute = "admin.$this->moduleName.translate.create";
				}
			}

			return view('datatables::actions', compact('actions', 'model', 'params', 'translationRoute', 'languages'));
		});
	}

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