<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class ConvertPersian extends TransformsRequest
{
	protected function transform($key, $value)
	{
		if (is_null($value) || empty($value)) {
			return $value;
		}

		$arabicAlpha = ['ض', 'ص', 'ث', 'ق', 'ف', 'غ', 'ع', 'ه', 'خ', 'ح', 'ج', 'ة', 'ش', 'س', 'ي', 'ب', 'ل', 'ا', 'ت', 'ن', 'م', 'ك', 'ظ', 'ط', 'ذ', 'د', 'ز', 'ر', 'و',];
		$persianAlpha = ['ض', 'ص', 'ث', 'ق', 'ف', 'غ', 'ع', 'ه', 'خ', 'ح', 'ج', 'ه', 'ش', 'س', 'ی', 'ب', 'ل', 'ا', 'ت', 'ن', 'م', 'ک', 'ظ', 'ط', 'ذ', 'د', 'ز', 'ر', 'و',];
		$value = str_replace($arabicAlpha, $persianAlpha, $value);
		$arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
		$englishNumbers = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
		$value = str_replace($arabicNumbers, $englishNumbers, $value);
		$persian = ['۰', '۱', '۲', '۳', '۴', '٤', '۵', '٥', '٦', '۶', '۷', '۸', '۹'];
		$english = [0, 1, 2, 3, 4, 4, 5, 5, 6, 6, 7, 8, 9];

		return str_replace($persian, $english, $value);
	}
}
