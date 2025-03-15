<?php

namespace App\Models;

use App\Traits\HasSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

class Project extends Model
{
	use HasFactory, SoftDeletes, HasSearch;

	protected $fillable = ['user_id', 'title', 'description'];
	protected $appends = ['created_at_jalali'];


	/*==========================Scopes==========================*/

	/*==========================Accessors==========================*/
	public function getCreatedAtJalaliAttribute(): string
	{
		$carbon = $this->created_at->setTimezone('Asia/Tehran');
		return Jalalian::fromCarbon($carbon)->format('Y/m/d');
	}

	/*==========================Relations==========================*/
	public function tasks(): HasMany
	{
		return $this->hasMany(Task::class);
	}
}
