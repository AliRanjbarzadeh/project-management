<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
	public function index()
	{
		$this->setPageTitle(__('forgot_password.singular'));
		return view('contents.forgot-password.index');
	}

	public function attempt(Request $request)
	{
	}
}
