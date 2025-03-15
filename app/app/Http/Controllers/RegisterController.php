<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\RegisterDto;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
	public function __construct(
		protected RegisterService $service,
	)
	{
	}

	public function index()
	{
		$this->setPageTitle(__('register.singular'));

		return view('contents.register.index');
	}

	public function attempt(RegisterRequest $request)
	{
		$user = $this->service->register(RegisterDto::fromRequest($request));

		if (is_null($user)) {
			return redirect()->back()->withInput()->withErrors(['message' => __('register.sentences.error')]);
		}

		Auth::guard('web')->login($user);

		return redirect(route('index'))->with('success', __('register.sentences.success'));
	}
}
