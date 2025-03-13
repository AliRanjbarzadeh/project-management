<?php

return [
	'singular' => 'ورود به داشبورد',

	//Fields
	'fields' => [
		'username' => 'ایمیل یا نام کاربری',
		'password' => 'کلمه عبور',
		'remember_me' => 'مرا بخاطر بسپار',
		'code' => 'کد تایید',
	],

	//Placeholders
	'placeholders' => [
		'username' => 'ایمیل یا نام کاربری خود را وارد کنید',
		'password' => '**********',
		'code' => 'مثلا: 12345',
	],

	//Errors
	'validations' => [
		'username' => [
			'required' => 'لطفا نام کاربری را وارد کنید',
		],
		'password' => [
			'required' => 'لطفا کلمه عبور را وارد کنید',
		],
		'exists' => 'نام کاربری و یا کلمه عبور اشتباه می باشد',
		'session' => [
			'expires' => 'نشست شما باطل شده است، لطفا مجددا وارد شوید',
		],
	],

	//Words
	'title' => 'خوش آمدید! 👋',
	'description' => 'لطفا اطلاعات حساب کاربری خود را وارد کنید',
	'buttons' => [
		'login' => 'ورود',
		'logout' => 'خروج',
	],

	//Actions

	//Sentences
	'sentences' => [
		'forgot_password' => 'رمز عبور را فراموش کرده اید؟',
		'new_user' => 'حساب کاربری ندارید؟',
		'register' => 'ثبت نام کنید',
	],

];