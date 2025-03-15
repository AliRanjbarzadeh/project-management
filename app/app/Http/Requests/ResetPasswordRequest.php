<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
			'email' => 'required|email|exists:users,email',
			'token' => 'required',
			'password' => 'required|string|min:8',
			'password_confirmation' => 'required|confirmed:password',
		];
	}

	public function messages()
	{
		return [
			'email.required' => __('reset_password.sentences.smth_went_wrong'),
			'email.email' => __('reset_password.sentences.smth_went_wrong'),
			'email.exists' => __('reset_password.sentences.smth_went_wrong'),
			'token.required' => __('reset_password.sentences.smth_went_wrong'),
			'password.required' => __('reset_password.validations.password.required'),
			'password.string' => __('reset_password.sentences.smth_went_wrong'),
			'password.min' => __('reset_password.validations.password.min'),
			'password_confirmation.required' => __('reset_password.validations.password_confirmation.required'),
			'password_confirmation.confirmed' => __('reset_password.validations.password_confirmation.match'),
		];
	}
}
