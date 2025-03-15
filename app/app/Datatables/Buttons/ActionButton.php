<?php

namespace App\DataTables\Buttons;

class ActionButton
{
	public string $title;
	public string $jsMethod;
	public bool $isButton = false;
	public ?string $icon = null;
	public string $htmlClass;
	public ?string $url = null;
	public ?string $modelName = null;
	public string $target;

	public function __construct(array $attributes, bool $isButton = false)
	{
		$this->title = $attributes['title'];
		$this->jsMethod = $attributes['js_method'] ?? '';
		$this->isButton = $isButton;
		$this->icon = $attributes['icon'] ?? null;
		$this->htmlClass = $attributes['html_class'];
		$this->url = $attributes['url'] ?? null;
		$this->modelName = $attributes['model_name'] ?? null;
		$this->target = $attributes['target'] ?? '';
	}

	public function isHasUrl(): bool
	{
		return $this->url !== null;
	}
}