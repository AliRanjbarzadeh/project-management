<?php

namespace App\Http\Requests\Api;

class TaskRequest extends BaseApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'project_id' => 'required|exists:projects,id',
			'title' => 'required|string|max:200',
			'description' => 'bail',
			'priority' => 'required|string|in:low,medium,high',
			'due_date' => !is_null($this->task) ? 'bail' : 'required',
			'deadline' => !is_null($this->task) ? 'bail' : 'required',
		];
	}

	public function messages()
	{
		return [
			'project_id.required' => __('task.validations.project_id.required'),
			'project_id.exists' => __('task.validations.project_id.exists'),
			'title.required' => __('task.validations.title.required'),
			'title.max' => __('task.validations.title.max'),
			'priority.required' => __('task.validations.priority.required'),
			'priority.in' => __('task.validations.priority.in'),
			'due_date.required' => __('task.validations.due_date.required'),
			'deadline.required' => __('task.validations.deadline.required'),
		];
	}
}
