<?php

namespace App\Http\ViewComposers\Menus;

use App\Http\ViewComposers\MenuInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProjectMenu implements MenuInterface
{
	public static function getMenu(Request $request, string $title = ''): Collection
	{
		return collect([
			'href' => 'javascript:void(0)',
			'is_active' => $request->routeIs('projects.*'),
			'icon' => 'bx bxs-package',
			'name' => __('project.plural'),
			'i18n' => 'Projects',
			'is_allowed' => true,
			'children' => collect([
				collect([
					'href' => route('projects.create'),
					'is_active' => $request->routeIs('projects.create'),
					'name' => __('global.actions.definition'),
					'i18n' => 'Projects Create',
					'is_allowed' => true,
				]),
				collect([
					'href' => route('projects.index'),
					'is_active' => $request->routeIs('projects.index', 'projects.edit', 'projects.tasks.*'),
					'name' => __('global.fields.archive'),
					'i18n' => 'Projects Archive',
					'is_allowed' => true,
				]),
			]),
		]);
	}
}