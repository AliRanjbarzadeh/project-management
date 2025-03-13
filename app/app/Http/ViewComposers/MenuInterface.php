<?php

namespace App\Http\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

interface MenuInterface
{
	public static function getMenu(Request $request, string $title = ''): Collection;
}