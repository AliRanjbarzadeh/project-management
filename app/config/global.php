<?php

return [
	'version' => [
		'resource' => env('RESOURCE_VERSION', 1),
	],

	'input' => [
		'priority' => [
			'min' => 1,
			'max' => 99999,
		],
		'items_per_page' => [
			'min' => 5,
			'max' => 50,
		],
	],
];
