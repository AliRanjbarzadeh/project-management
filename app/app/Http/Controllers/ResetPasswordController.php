<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ResetPasswordDto;
use App\Http\Requests\ResetPasswordRequest;
use App\Services\AuthService;

class ResetPasswordController extends Controller
{
	public function __construct(
		protected AuthService $authService,
	)
	{
	}

	public function index(string $token)
	{
		abort_if(empty($token), 404);

		$this->setPageTitle(__('reset_password.singular'));

		return view('contents.reset-password.index', compact('token'));
	}

	public function attempt(ResetPasswordRequest $request)
	{
		if (!$this->authService->resetPassword(ResetPasswordDto::fromRequest($request))) {
			return back()->withErrors(['message' => __('reset_password.sentences.smth_went_wrong')]);
		}

		return redirect(route('login'))->with('success', __('reset_password.sentences.success'));
	}
}
