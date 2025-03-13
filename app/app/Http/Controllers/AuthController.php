<?php

namespace App\Http\Controllers;

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
		if (auth('admin')->validate(array_merge($request->only('username', 'password'), ['is_active' => true]))) {
			auth('admin')->attempt(array_merge($request->only('username', 'password'), ['is_active' => true]), $request->input('remember'));
			$redirectUrl = session()?->get('url.intended', route('index'));
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

		return redirect(route('login.index'));
	}

	/*==================Create====================*/

	/*==================Edit====================*/
}
