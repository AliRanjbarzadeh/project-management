<?php

namespace App\Http\ViewComposers\Admin\Menus;

use App\Facades\Permission;
use App\Http\ViewComposers\MenuInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AdminMenu implements MenuInterface
{
	public static function getMenu(Request $request, string $title = ''): Collection
	{
		return collect([
			'href' => 'javascript:void(0)',
			'is_active' => $request->routeIs('admin.admins.*'),
			'icon' => 'bx bx-user',
			'name' => __('admin/admin.plural'),
			'i18n' => 'Admins',
			'is_allowed' => Permission::can([
				'admins.index',
				'admins.create',
			]),
			'children' => collect([
				collect([
					'href' => route('admin.admins.create'),
					'is_active' => $request->routeIs('admin.admins.create'),
					'name' => __('admin/global.actions.definition'),
					'i18n' => 'Admins Create',
					'is_allowed' => Permission::can([
						'admins.create',
					]),
				]),
				collect([
					'href' => route('admin.admins.index'),
					'is_active' => $request->routeIs('admin.admins.index', 'admin.admins.edit'),
					'name' => __('admin/global.fields.archive'),
					'i18n' => 'Admins Archive',
					'is_allowed' => Permission::can([
						'admins.index',
					]),
				]),
			]),
		]);
	}
}