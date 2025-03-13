<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

abstract class Controller
{
	protected function setPageTitle(string $pageTitle = ''): void
	{
		View::share('pageTitle', $pageTitle);
	}
}
