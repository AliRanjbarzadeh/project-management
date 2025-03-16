<?php

namespace App\Enums;

enum HttpStatusEnum
{
	// Success responses
	const OK = 200;

	// Client errors
	const BAD_REQUEST = 400;
	const UNAUTHORIZED = 401;
	const FORBIDDEN = 403;
	const NOT_FOUND = 404;
	const VALIDATION = 422;
}
