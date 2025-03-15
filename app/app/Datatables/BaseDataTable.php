<?php

namespace App\Datatables;

use App\DataTables\Buttons\ActionButton;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class BaseDataTable extends DataTable
{
	protected array $attributes = [
		'filterable' => true,
		'has_priority' => true,
		'exportable' => true,
		'export_url' => null,
		'priority_url' => null,
		'model_name' => null,
	];

	/**
	 * @var array|ActionButton[]
	 */
	private array $actionButtons;

	/**
	 * @var array|ActionButton[]
	 */
	private array $actionLinks = [];

	protected Collection $categories;
	protected Collection $categoryFilters;
	protected Collection $multipleCategory;
	protected array $modals = [];
	protected array $dropdowns = [];
	protected Collection $statistics;

	public function __construct()
	{
		parent::__construct();

		$this->multipleCategory = collect();
		$this->statistics = collect();
		$this->categories = collect();
		$this->categoryFilters = collect();
	}

	public function dataTable(QueryBuilder $query): EloquentDataTable
	{
		return (new EloquentDataTable($query))->setRowId('id');
	}

	public function query(Model $model): QueryBuilder
	{
		return $model->newQuery();
	}

	public function html(): HtmlBuilder
	{
		return $this->builder()
			->parameters([
				'searching' => true,
				'drawCallback' => 'function() { $(\'[data-bs-toggle="tooltip"]\').tooltip(); handleInputs(); }',
				'initComplete' => 'function(settings) { sessionStorage.setItem(settings.sTableId + "Sort", JSON.stringify(settings.aaSorting)); handleInputs(); }',
			])
			->serverSide()
			->columns($this->getColumns())
			->pageLength(Cookie::get('paging', 10))
			->lengthMenu([10, 25, 50, 75, 100, 200, 500, 1000, 2000])
			->searching(false)
			->autoWidth(false)
			->ordering()
			->responsive()
			->addTableClass("table-striped table-hover")
			->dom('lfrt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>')
			->language(asset('assets/vendor/libs/datatables/languages/fa.json'));
	}

	/**
	 * Process dataTables needed render output.
	 *
	 * @param string|null $view
	 * @param array $data
	 * @param array $mergeData
	 *
	 * @return mixed
	 */
	public function render(string $view = null, array $data = [], array $mergeData = []): mixed
	{
		$mergeData['filters'] = $this->getTopBlock();
		return parent::render($view, $data, $mergeData);
	}

	protected function filterable(bool $flag = true): static
	{
		$this->attributes['filterable'] = $flag;
		return $this;
	}

	protected function exportable(bool $flag = true): static
	{
		$this->attributes['exportable'] = $flag;
		return $this;
	}

	/**
	 * @return array|ActionButton[]
	 */
	private function getActionButtons(): array
	{
		$actionButtons = [];

		if ($this->attributes['filterable']) {
			$actionButtons[] = new ActionButton([
				'title' => __('datatables.actions.delete_filters'),
				'js_method' => 'delete-filters',
				'html_class' => 'btn-danger',
				'icon' => 'bx bxs-trash',
			], true);
		}

		if ($this->attributes['exportable']) {
			$actionButtons[] = new ActionButton([
				'title' => __('datatables.actions.export_excel'),
				'js_method' => 'export-excel',
				'html_class' => 'btn-success',
				'icon' => 'bx bx-export',
				'url' => $this->attributes['export_url'],
				'target' => '_blank',
			], true);
		}

		if ($this->attributes['has_priority']) {
			$actionButtons[] = new ActionButton([
				'title' => __('datatables.actions.update_priority'),
				'js_method' => 'update-priority',
				'html_class' => 'btn-info',
				'icon' => 'bx bx-refresh',
				'url' => $this->attributes['priority_url'],
				'model_name' => $this->attributes['model_name'],
			], true);
		}

		if (!empty($this->actionButtons)) {
			$actionButtons = array_merge($actionButtons, $this->actionButtons);
		}

		return $actionButtons;
	}

	/**
	 * Action buttons shows below filters
	 *
	 * @param ActionButton $actionButton
	 * @return $this
	 */
	public function addActionButton(ActionButton $actionButton): static
	{
		$this->actionButtons[] = $actionButton;
		return $this;
	}

	/**
	 * Action links shows below table action button filters
	 *
	 * @param ActionButton $actionLink
	 * @return $this
	 */
	public function addActionLink(ActionButton $actionLink): static
	{
		$this->actionLinks[] = $actionLink;
		return $this;
	}

	public function addModal(array $modal): static
	{
		$this->modals[] = $modal;
		return $this;
	}

	public function addDropDown(string $key, array $values): static
	{
		$this->dropdowns[$key] = $values;
		return $this;
	}

	public function getColumns(): array
	{
		return [];
	}

	public function getTopBlock(): string
	{
		$inputs = collect($this->getColumns())->where('searchable', '=', true);
		$actionButtons = $this->getActionButtons();
		$actionLinks = $this->actionLinks;
		$modals = $this->modals;
		$dropdowns = $this->dropdowns;

		return view('datatables::filters', compact('inputs', 'actionButtons', 'actionLinks', 'modals', 'dropdowns'))->render();
	}
}