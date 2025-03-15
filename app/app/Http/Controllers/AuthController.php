<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\AuthDto;
use App\Http\Requests\AuthRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
	public function __construct(
		protected AuthService $service,
	)
	{
	}

	/*==================Index====================*/
	public function index()
	{
		$this->setPageTitle(__('auth.singular'));
		return view('contents.auth.index');
	}

	public function attempt(AuthRequest $request)
	{
		$dto = AuthDto::fromRequest($request);

		if (auth('web')->validate($dto->toArray())) {
			auth('web')->attempt($dto->toArray(), $dto->remember);
			$redirectUrl = session()?->pull('url.intended', route('index'));
			return redirect()->intended($redirectUrl);
		}

		return redirect()
			->back()
			->withInput()
			->withErrors(['message' => __('auth.validations.exists')]);
	}

	public function logout()
	{
		auth('web')->logout();

		return redirect(route('login'));
	}

	/*==================Create====================*/

	/*==================Edit====================*/
}
