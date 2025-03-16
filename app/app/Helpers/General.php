<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use JsonException;

class General
{
	/**
	 * @param mixed $value
	 *
	 * @return mixed
	 */
	public static function toJson(mixed $value): mixed
	{
		try {
			if (is_null($value)) {
				return null;
			}

			if (is_numeric($value)) {
				return $value;
			}

			if (is_string($value)) {
				return $value;
			}

			return json_encode($value, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		} catch (JsonException $e) {
			Log::error('json encode error -> ' . $e->getMessage(), $e->getTrace());
			return null;
		}
	}

	/**
	 * @param string|null $value
	 * @param bool $isArray
	 *
	 * @return mixed
	 */
	public static function fromJson(string|null $value, bool $isArray = false): mixed
	{
		try {
			if (!is_null($value)) {
				return json_decode($value, $isArray, 512, JSON_THROW_ON_ERROR);
			}
			return null;
		} catch (JsonException $e) {
			Log::error('json decode error -> ' . $e->getMessage(), $e->getTrace());
			return $value;
		}
	}

	public static function toSeoUrl(string $url): string
	{
		return empty($url) ? $url : implode("-", preg_split('/\s+/', preg_replace('/[!-\/:-@[-`{-~÷٬٫٪×،ـ؟]+/', '', str_replace("-", " ", $url))));
	}

	public static function country2flag(?string $countryCode): string
	{
		if (empty($countryCode)) {
			return '';
		}
		return (string)preg_replace_callback(
			'/./',
			static fn(array $letter) => mb_chr(ord($letter[0]) % 32 + 0x1F1E5),
			$countryCode,
		);
	}

	public static function getUrlSegment(int $index): ?string
	{
		if (app()->getLocale() !== app()->getFallbackLocale()) {
			++$index;
		}
		return request()->segment($index);
	}

	public static function parseFilterSegments(array $urlSegments): bool|Collection
	{
		$allowedRoutes = collect(config('consultations.filter.routes'));
		$segments = collect(config('consultations.filter.segments'));
		$mUrlSegments = collect($urlSegments);

		$params = $mUrlSegments->filter(function ($segment) use ($allowedRoutes) {
			return $allowedRoutes->contains($segment);
		})
			->values()
			->map(function ($mUrlSegment) use ($segments, $mUrlSegments) {
				$rule = $segments->get($mUrlSegment);
				if ($rule['has_next']) {
					return collect([
						'key' => $mUrlSegment,
						'value' => $mUrlSegments->after($mUrlSegment),
					]);
				}

				return collect([
					'key' => $mUrlSegment,
					'value' => true,
				]);
			});

		$faults = $mUrlSegments->filter(function ($segment) use ($allowedRoutes, $params) {
			return !$allowedRoutes->contains($segment) && $params->filter(fn($param) => $param->get('value') === $segment)->isEmpty();
		});

		if ($faults->isEmpty()) {
			return $params;
		}

		return false;
	}

	public static function getCacheTime(int $time = 10): Carbon
	{
		return now()->addMinutes($time);
	}

	public static function getLogo(string $size = '')
	{
		$logo = config('globals')->setting->logo;
		if (!empty($size) && property_exists($logo, 'options')) {
			if (property_exists($logo->options, 'subSizes')) {
				if (property_exists($logo->options->subSizes, $size)) {
					return $logo->options->subSizes->{$size};
				}
			}
		}
		return $logo->path;
	}

	public static function getFormattedPriceByLocale(mixed $price, ?User $user = null): string
	{
		$locale = app()->getLocale();
		$decimal = 0;
		$sign = __(key: 'global.words.price_unit', locale: 'fa');
		if ($user?->is_foreign || $locale === 'en') {
			$decimal = 2;
			$sign = __(key: 'global.words.price_unit', locale: 'en');
		}

		$formattedPrice = number_format($price, $decimal);

		if ($sign === '$') {
			return $sign . $formattedPrice;
		}
		return $formattedPrice . ' ' . $sign;
	}

	public static function getFormattedPriceByUser(mixed $price, User $user): string
	{
		$decimal = 0;
		$sign = __(key: 'global.words.price_unit', locale: 'fa');
		if ($user->is_foreign) {
			$decimal = 2;
			$sign = __(key: 'global.words.price_unit', locale: 'en');
		}

		$formattedPrice = number_format($price, $decimal);

		if ($sign === '$') {
			return $sign . $formattedPrice;
		}
		return $formattedPrice . ' ' . $sign;
	}

	public static function getAvailableLocales(): array
	{
		return collect(config('translatable.locales'))->filter(fn($item) => $item !== 'fa')->toArray();
	}

	public static function getAvailableLanguages(array $exceptions = []): array
	{
		return collect(config('translatable.locales', []))->filter(function ($locale) use ($exceptions) {
			return !in_array($locale, $exceptions, true);
		})->map(function ($language) {
			return [
				'name' => __('admin/translation.words.languages.' . $language),
				'url' => $language,
				'flag' => General::country2flag(__('admin/translation.words.flags.' . $language)),
			];
		})->toArray();
	}
}