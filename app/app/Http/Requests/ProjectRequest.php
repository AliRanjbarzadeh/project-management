<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
			'title' => 'required|max:255',
			'description' => 'bail',
		];
	}

	public function messages(): array
	{
		return [
			'title.required' => __('project.validations.title.required'),
			'title.max' => __('project.validations.title.max'),
		];
	}
}
