<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Str;

abstract class TestCase extends BaseTestCase
{
	public function call($method, $uri, $parameters = [], $cookies = [], $files = [], $server = [], $content = null)
	{
		if (in_array(Str::lower($method), ['post', 'get', 'put', 'delete'])) {
			$parameters['_token'] = csrf_token();
		}
		return parent::call($method, $uri, $parameters, $cookies, $files, $server, $content);
	}
}
