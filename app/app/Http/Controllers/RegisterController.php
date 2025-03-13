<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
	public function index()
	{
		return view('contents.register.index');
    }

	public function register(Request $request)
	{
	}
}
