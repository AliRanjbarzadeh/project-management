<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Morilog\Jalali\Jalalian;

trait HasSearch
{
	/**
	 * @param Builder $query
	 * @param string|null $fromDate
	 * @param string|null $toDate
	 *
	 * @return void
	 */
	public function scopeDateRangeSearch(Builder $query, ?string $fromDate, ?string $toDate): void
	{
		$fromDateStr = '';
		$toDateStr = '';
		if (!empty($fromDate)) {
			$fromDateStr = Jalalian::fromFormat('Y/m/d', $fromDate)->toCarbon()->format('Y-m-d');
		}

		if (!empty($toDate)) {
			$toDateStr = Jalalian::fromFormat('Y/m/d', $toDate)->toCarbon()->format('Y-m-d');
		}

		if (!empty($fromDateStr) && !empty($toDateStr)) {
			$query->whereDate('created_at', '>=', $fromDateStr)
				->whereDate('created_at', '<=', $toDateStr);
		}

		if (!empty($fromDateStr) && empty($toDateStr)) {
			$query->whereDate('created_at', '=', $fromDateStr);
		}

		if (empty($fromDateStr) && !empty($toDateStr)) {
			$query->whereDate('created_at', '<=', $toDateStr);
		}
	}

	/**
	 * @param Builder $query
	 * @param string|null $term
	 * @param string|array $columns
	 *
	 * @return void
	 */
	public function scopeRegexpSearch(Builder $query, ?string $term, string|array $columns): void
	{
		if (is_null($term)) {
			return;
		}
		if (!is_array($columns)) {
			$columns = [$columns];
		}

		if (!empty(trim($term))) {
			$terms = explode(' ', $term);
			$query->where(function (Builder $query) use ($columns, $terms) {
				foreach ($terms as $termKey => $termValue) {
					foreach ($columns as $key => $column) {
						if ($termKey == 0 && $key == 0) {
							$query->where($column, 'like', "%$termValue%");
						} else {
							$query->orWhere($column, 'like', "%$termValue%");
						}
					}
				}
			});
		}
	}

	public function scopeCustomColumnSearch(Builder $query, string $column, string $operator, mixed $value): void
	{
		if (!is_null($value)) {
			$query->where($column, $operator, $value);
		}
	}

	public function scopeBooleanSearch(Builder $query, string $column, mixed $value = null): void
	{
		if (!is_null($value)) {
			$query->where($column, '=', $value);
		}
	}
}