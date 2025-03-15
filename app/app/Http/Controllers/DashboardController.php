<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
	public function index()
	{
		$this->setPageTitle(__('dashboard.singular'));

		return view('contents.dashboard.index');
	}

}
