<?php

return [
	'singular' => 'بازیابی کلمه عبور',
	'description' => 'برای بازیابی کلمه عبور خود روی لینک زیر کلیک کنید',

	//Fields
	'fields' => [
		'email' => 'ایمیل',
		'password' => 'کلمه عبور جدید',
		'password_confirmation' => 'تکرار کلمه عبور جدید',
	],

	//Placeholders
	'placeholders' => [
		'email' => 'ایمیل  خود را وارد کنید',
		'password' => '**********',
	],

	//Errors
	'validations' => [
		'email' => [
			'required' => 'لطفا ایمیل را وارد کنید',
			'invalid' => 'ایمیل وارد شده معتبر نمی باشد',
			'exists' => 'حساب کاربری با ایمیل وارد شده وجود ندارد',
		],
		'password' => [
			'required' => 'لطفا کلمه عبور جدید را وارد کنید',
			'min' => 'طول کلمه عبور جدید حداقل باید 8 کارکاتر باشد',
			'match' => 'کلمه عبور جدید با تکرار کلمه عبور جدید باید یکسان باشد',
		],
	],

	//Words

	//Actions
	'actions' => [
		'new_password' => 'تنظیم کلمه عبور جدید',
		'reset_password' => 'بازنشانی کلمه عبور',
	],

	//Sentences
	'sentences' => [
		'success' => 'کلمه عبور با موفقیت بازیابی شد',
		'smth_went_wrong' => 'خطایی رخ داده است، لطفا دوباره تلاش کنید',
	],

];