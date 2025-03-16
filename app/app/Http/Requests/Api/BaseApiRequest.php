<?php

namespace App\Http\Requests\Api;

use App\Http\Resources\Api\ValidationErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BaseApiRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * @param Validator $validator
	 * @return mixed
	 */
	protected function failedValidation(Validator $validator)
	{
		$resource = new ValidationErrorResource($validator);

		throw new ValidationException($validator, $resource->response());
	}
}
