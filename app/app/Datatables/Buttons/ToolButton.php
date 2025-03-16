<?php

namespace App\DataTables\Buttons;

/**
 * Using in tools of row in Datatables
 */
class ToolButton
{
	public string $title;
	public mixed $url;
	public string $icon;
	public ?string $onClick = null;
	public bool $isButton;

	public function __construct(array $attributes = [], bool $isButton = false, ?string $onClick = null)
	{
		$this->title = $attributes['title'];
		$this->url = $attributes['url'];
		$this->icon = $attributes['icon'];
		$this->onClick = $onClick;
		$this->isButton = $isButton;
	}
}