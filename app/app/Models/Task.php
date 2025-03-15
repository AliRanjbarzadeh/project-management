<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

	public function getDeadlineJalaliAttribute(): string
	{
		$carbon = $this->deadline->setTimezone('Asia/Tehran');
		return Jalalian::fromCarbon($carbon)->format('Y/m/d');
	}

	public function setDueDateAttribute($value): void
	{
		$this->attributes['due_date'] = Jalalian::fromFormat('Y/m/d', $value)->toCarbon()->format('Y-m-d');
	}

	public function setDeadlineAttribute($value): void
	{
		$this->attributes['deadline'] = Jalalian::fromFormat('Y/m/d', $value)->toCarbon()->format('Y-m-d');
	}

	/*==========================Relations==========================*/
}
