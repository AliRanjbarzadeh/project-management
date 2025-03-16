<?php

namespace App\Providers;

use App\Http\ViewComposers\SideMenuComposer;
use Illuminate\Support\ServiceProvider;

/**
 * Provide dashboard side menu
 */
class DashboardMenuProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		$this->sideMenu();
	}

	private function sideMenu()
	{
		view()->composer('layouts.aside-menu', SideMenuComposer::class);
	}
}
