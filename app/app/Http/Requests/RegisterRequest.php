<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
			'full_name' => 'required|string|max:255',
			'username' => 'required|string|max:100|unique:users,username',
			'email' => 'required|email|max:100|unique:users,email',
			'password' => 'required|string|min:8|confirmed',
		];
	}

	public function messages(): array
	{
		return [
			'full_name.required' => __('register.validations.full_name.required'),
			'username.required' => __('register.validations.username.required'),
			'username.unique' => __('register.validations.username.required'),
			'username.max' => __('register.validations.username.max'),
			'email.required' => __('register.validations.email.required'),
			'email.unique' => __('register.validations.email.unique'),
			'email.max' => __('register.validations.email.max'),
			'password.required' => __('register.validations.password.required'),
			'password.min' => __('register.validations.password.min'),
			'password.confirmed' => __('register.validations.password.match'),
		];
	}
}
