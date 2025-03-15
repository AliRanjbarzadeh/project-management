<?php

namespace App\Http\ViewComposers;

use App\Http\ViewComposers\Menus\ProjectMenu;
use App\Http\ViewComposers\Menus\SeparatorMenu;
use Illuminate\View\View;

class SideMenuComposer
{
	public function __construct()
	{
	}

	public function compose(View $view): void
	{
		$request = request();

		$menus = collect([
			//Dashboard
			collect([
				'href' => route('index'),
				'is_active' => $request->routeIs('index'),
				'icon' => 'bx bxs-dashboard',
				'name' => __('dashboard.singular'),
				'i18n' => 'Dashboard',
				'is_allowed' => true,
			]),

			//Separator
			SeparatorMenu::getMenu($request, __('global.words.basic_information')),

			//Projects
			ProjectMenu::getMenu($request, __('project.plural')),
		]);

		$view->with('menus', $menus);
	}
}