<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		$this->app->register(DashboardMenuProvider::class);

		if ($this->app->isLocal()) {
			$this->app->register(TelescopeServiceProvider::class);
		}
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		$this->resourceVersion();
	}

	private function resourceVersion()
	{
		$resourceVersion = config('global.version.resource');
		if (app()->isLocal()) {
			$resourceVersion = time();
		}
		View::share('resourceVersion', $resourceVersion);
	}
}
