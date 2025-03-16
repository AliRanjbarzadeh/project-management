<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStatusRequest extends FormRequest
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
			'status' => 'required|in:complete,incomplete',
		];
	}

	public function messages(): array
	{
		return [
			'status.required' => __('task.validations.status.required'),
			'status.in' => __('task.validations.status.in'),
		];
	}
}
