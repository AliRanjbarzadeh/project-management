<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;

class RouteController extends Controller
{
	public function translations()
	{
		$files = array_merge(glob(base_path('lang/fa/**/*.php')), glob(base_path('lang/fa/*.php')));
		$strings = [];
		foreach ($files as $file) {
			$arr = explode('/', str_replace(base_path('lang/fa/'), '', $file));
			array_pop($arr);
			$name = basename($file, '.php');
			if (empty($arr)) {
				$strings[$name] = require $file;
			} else {
				$strings[implode('/', $arr) . '/' . $name] = require $file;
			}
		}

		$content = "const currentLocale = '" . config('app.locale') . "';
const dataLocale = '" . (request()->input('locale') ?? config('app.locale')) . "';
const allLangs = " . json_encode(Arr::dot($strings), JSON_UNESCAPED_UNICODE) . ";
window.__ = function(name, parameters = null) {
  let lang = allLangs[name];
  if (parameters) {
     for (const param of Object.keys(parameters)) {
        lang = lang.replace(new RegExp(':'+param, 'g'), parameters[param]);
     }
     return lang;
  } else {
     return lang;
  }
}";
		return response($content)->header('Content-Type', 'application/javascript');
	}

	public function router()
	{
		$routes_name = array_keys(app('router')->getRoutes()->getRoutesByName());

		$routes = [];
		foreach ($routes_name as $route) {
			$uri = app('router')->getRoutes()->getByName($route)?->uri();

			if (!is_null($uri)) {
				$routes[] = [
					'name' => $route,
					'uri' => urlencode($uri),
				];
			}
		}

		$content = "let allRoutes = JSON.parse('" . json_encode($routes, JSON_UNESCAPED_UNICODE) . "');
window.route = function (name, parameters = null) {
	const r = allRoutes.find(x => x.name === name);
	if (parameters) {
		let uri = r.uri;
		for (const param of Object.keys(parameters)) {
			uri = uri.replace(new RegExp(encodeURIComponent('{' + param + '}'), 'g'), parameters[param]);
			uri = uri.replace(new RegExp(encodeURIComponent('{' + param + '?}'), 'g'), parameters[param]);
		}
		return baseUrl + decodeURIComponent(uri) + '/';
	} else {
		return baseUrl + decodeURIComponent(r.uri) + '/';
	}
}";

		return response($content)->header('Content-Type', 'application/javascript');
	}
}
