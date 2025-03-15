<?php

namespace App\Console\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Utils;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishDynamicResources extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'resource:dynamic';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Publish dynamic resources in static files';

	/**
	 * Execute the console command.
	 */
	public function handle(): void
	{
		$client = new Client([
			'verify' => false,
		]);

		$this->adminResources($client);
	}

	private function adminResources(Client $client): void
	{
		if (!File::exists(public_path("assets/js/"))) {
			File::makeDirectory(public_path("assets/js"));
		}

		if (File::exists(public_path("assets/js/router.js"))) {
			File::delete(public_path("assets/js/router.js"));
		}
		$routeResource = Utils::tryFopen(public_path("assets/js/router.js"), 'w');
		$client->request('GET', route('assets.router', false), ['sink' => $routeResource]);

		if (File::exists(public_path("assets/js/translations.js"))) {
			File::delete(public_path("assets/js/translations.js"));
		}
		$translationResource = Utils::tryFopen(public_path("assets/js/translations.js"), 'w');
		$client->request('GET', route('assets.translations'), ['sink' => $translationResource]);
	}
}
