<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return auth('web')->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
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
			'title.required' => __('task.validations.title.required'),
			'title.max' => __('task.validations.title.max'),
			'priority.required' => __('task.validations.priority.required'),
			'priority.in' => __('task.validations.priority.in'),
			'due_date.required' => __('task.validations.due_date.required'),
			'deadline.required' => __('task.validations.deadline.required'),
		];
	}
}
