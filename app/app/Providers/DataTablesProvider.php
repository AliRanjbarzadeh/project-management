<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class DataTablesProvider extends ServiceProvider
{
	/**
	 * Register services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap services.
	 */
	public function boot(): void
	{
		//Filters and actions
		Blade::directive('datatablesTopHead', function () {
			return '<?php echo isset($filters) ? $filters : ""; ?>';
		});
	}
}
