<?php

namespace App\Datatables;

use App\DataTables\Buttons\ActionButton;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
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
	 * Action buttons used in filter area (for example: Clear filter button)
	 *
	 * @var array|ActionButton[]
	 */
	private array $actionButtons;

	/**
	 * Action links used below action buttons in filter area (for example: New item link for that table)
	 *
	 * @var array|ActionButton[]
	 */
	private array $actionLinks = [];

	/**
	 * Modals used for javascript call to actions
	 *
	 * @var array
	 */
	protected array $modals = [];

	/**
	 * Using for filters need to be select2 (for example: status)
	 *
	 * @var array
	 */
	protected array $dropdowns = [];

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

	/**
	 * Mark table as filterable
	 *
	 * @param bool $flag
	 * @return $this
	 */
	protected function filterable(bool $flag = true): static
	{
		$this->attributes['filterable'] = $flag;
		return $this;
	}

	/**
	 * Mark table as exportable (Export Excel)
	 *
	 * @param bool $flag
	 * @return $this
	 */
	protected function exportable(bool $flag = true): static
	{
		$this->attributes['exportable'] = $flag;
		return $this;
	}

	/**
	 * Get action buttons
	 *
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
	 * Append action button
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
	 * Append action links
	 *
	 * @param ActionButton $actionLink
	 * @return $this
	 */
	public function addActionLink(ActionButton $actionLink): static
	{
		$this->actionLinks[] = $actionLink;
		return $this;
	}

	/**
	 * Append modal
	 *
	 * @param array $modal
	 * @return $this
	 */
	public function addModal(array $modal): static
	{
		$this->modals[] = $modal;
		return $this;
	}

	/**
	 * Append dropdown
	 *
	 * @param string $key
	 * @param array $values
	 * @return $this
	 */
	public function addDropDown(string $key, array $values): static
	{
		$this->dropdowns[$key] = $values;
		return $this;
	}

	/**
	 * Get table columns
	 *
	 * @return array
	 */
	public function getColumns(): array
	{
		return [];
	}

	/**
	 * Get top block of table (filters, action buttons and ...)
	 * @return string
	 * @throws \Throwable
	 */
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