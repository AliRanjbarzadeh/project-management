<?php

if (!function_exists('get_status_text')) {
	function get_status_text(bool $flag): string
	{
		if ($flag) {
			return __('status.fields.1');
		}
		return __('status.fields.0');
	}
}