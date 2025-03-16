<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
			'full_name' => 'required',
			'email' => 'required|email|max:100|unique:users,email,' . $this->user()->id,
		];
	}

	public function messages(): array
	{
		return [
			'full_name.required' => __('profile.validations.full_name.required'),
			'email.required' => __('profile.validations.email.required'),
			'email.unique' => __('profile.validations.email.unique'),
			'email.max' => __('profile.validations.email.max'),
		];
	}
}
