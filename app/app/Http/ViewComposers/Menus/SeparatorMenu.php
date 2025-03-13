<?php

namespace App\Http\ViewComposers\Menus;

use App\Http\ViewComposers\MenuInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SeparatorMenu implements MenuInterface
{
	public static function getMenu(Request $request, string $title = ''): Collection
	{
		return collect([
			'name' => $title,
			'is_separator' => true,
		]);
	}
}