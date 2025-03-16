<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskPriorityRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'priority' => 'required|in:low,medium,high',
		];
	}

	public function messages(): array
	{
		return [
			'priority.required' => __('task.validations.priority.required'),
			'priority.in' => __('task.validations.priority.in'),
		];
	}
}
