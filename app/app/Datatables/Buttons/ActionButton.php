<?php

namespace App\DataTables\Buttons;

/**
 * Using in filter section of Datatables
 */
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
		$this->title = $attributes['title']; //Button text
		$this->jsMethod = $attributes['js_method'] ?? ''; //Call to action of javascript
		$this->isButton = $isButton; //Determine the button is a or button
		$this->icon = $attributes['icon'] ?? null; //Icon of button
		$this->htmlClass = $attributes['html_class']; //Button class based on bootstrap 5.1
		$this->url = $attributes['url'] ?? null; //Url of button to go with a or call to action for javascript
		$this->modelName = $attributes['model_name'] ?? null; //Model class string name to use for relations
		$this->target = $attributes['target'] ?? ''; //Determine to show link in new tab or not
	}

	/**
	 * Check if button has url
	 * @return bool
	 */
	public function isHasUrl(): bool
	{
		return $this->url !== null;
	}
}