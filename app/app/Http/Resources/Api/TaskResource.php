<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
	public static $wrap = null;

	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'description' => $this->description,
			'project_title' => $this->project->title,
			'status' => $this->status,
			'priority' => $this->priority,
			'due_date' => $this->due_date_jalali,
			'deadline' => $this->deadline_jalali,
		];
	}
}
