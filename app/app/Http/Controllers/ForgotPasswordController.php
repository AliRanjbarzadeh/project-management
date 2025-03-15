<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Services\AuthService;

class ForgotPasswordController extends Controller
{
	public function __construct(
		protected AuthService $authService,
	)
	{
	}

	public function index()
	{
		$this->setPageTitle(__('forgot_password.singular'));
		return view('contents.forgot-password.index');
	}

	public function attempt(ForgotPasswordRequest $request)
	{
		if (!$this->authService->sendForgotPasswordRequest($request->input('email'))) {
			return back()->withErrors(['message' => __('forgot_password.sentences.user_not_found')]);
		}

		return back()->with('success', __('forgot_password.sentences.password_link_sent'));
	}
}
