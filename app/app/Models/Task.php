<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Morilog\Jalali\Jalalian;

class Task extends Model
{
	use HasFactory, SoftDeletes, HasSearch;

	protected $fillable = [
		'user_id',
		'project_id',
		'title',
		'description',
		'status',
		'priority',
		'due_date',
		'deadline',
	];
	protected $appends = ['created_at_jalali', 'due_date_jalali', 'deadline_jalali'];
	protected $casts = [
		'due_date' => 'date',
		'deadline' => 'date',
	];

	/*==========================Scopes==========================*/

	/*==========================Accessors==========================*/
	public function getCreatedAtJalaliAttribute(): string
	{
		$carbon = $this->created_at->setTimezone('Asia/Tehran');
		return Jalalian::fromCarbon($carbon)->format('Y/m/d');
	}

	public function getDueDateJalaliAttribute(): string
	{
		$carbon = $this->due_date->setTimezone('Asia/Tehran');
		return Jalalian::fromCarbon($carbon)->format('Y/m/d');
	}

	public function setDueDateAttribute($value): void
	{
		$this->attributes['due_date'] = Jalalian::fromFormat('Y/m/d', $value)->toCarbon()->format('Y-m-d');
	}

	public function getDeadlineJalaliAttribute(): string
	{
		$carbon = $this->deadline->setTimezone('Asia/Tehran');
		return Jalalian::fromCarbon($carbon)->format('Y/m/d');
	}

	public function setDeadlineAttribute($value): void
	{
		$this->attributes['deadline'] = Jalalian::fromFormat('Y/m/d', $value)->toCarbon()->format('Y-m-d');
	}

	public function getPriorityTextAttribute(): string
	{
		return __('task.priorities.' . $this->priority);
	}

	public function getPriorityDropDownAttribute(): string
	{
		try {
			$btnClass = 'btn-success';
			if ($this->priority === 'medium') {
				$btnClass = 'btn-warning';
			} else if ($this->priority === 'high') {
				$btnClass = 'btn-danger';
			}

			return view('contents.tasks.change-priority', [
				'url' => route('projects.tasks.change-priority', [$this->project_id, $this->id]),
				'priorityText' => $this->priority_text,
				'priority' => $this->priority,
				'id' => $this->id,
				'btnClass' => $btnClass,
			])->render();
		} catch (\Throwable $e) {
			Log::error($e->getMessage(), $e->getTrace());
			return '';
		}
	}

	public function getStatusTextAttribute(): string
	{
		return __('task.statuses.' . $this->status);
	}

	public function getStatusDropDownAttribute(): string
	{
		try {
			$btnClass = 'btn-success';
			if ($this->status === 'incomplete') {
				$btnClass = 'btn-warning';
			}

			return view('contents.tasks.change-status', [
				'url' => route('projects.tasks.change-status', [$this->project_id, $this->id]),
				'statusText' => $this->status_text,
				'status' => $this->status,
				'id' => $this->id,
				'btnClass' => $btnClass,
			])->render();
		} catch (\Throwable $e) {
			Log::error($e->getMessage(), $e->getTrace());
			return '';
		}
	}

	/*==========================Relations==========================*/
}
