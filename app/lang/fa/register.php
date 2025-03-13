<?php

return [
	'singular' => 'فراموشی کلمه عبور',
	'title' => 'ثبت نام',
	'description' => 'مدیریت پروژه های خود را آسان کنید!',

	//Fields
	'fields' => [
		'full_name' => 'نام و نام خانوادگی',
		'email' => 'ایمیل',
		'username' => 'نام کاربری',
		'password' => 'کلمه عبور',
		're_password' => 'تکرار کلمه عبور',
	],

	//Placeholders
	'placeholders' => [
		'full_name' => 'نام و نام خانوادگی خود را وارد کنید',
		'email' => 'ایمیل  خود را وارد کنید',
		'username' => 'نام کاربری  خود را وارد کنید',
		'password' => 'کلمه عبور  خود را وارد کنید',
		're_password' => 'تکرار کلمه عبور  خود را وارد کنید',
	],

	//Errors
	'validations' => [
		'full_name' => [
			'required' => 'لطفا نام و نام خانوادگی را وارد کنید',
		],
		'email' => [
			'required' => 'لطفا ایمیل را وارد کنید',
			'invalid' => 'ایمیل وارد شده معتبر نمی باشد',
			'unique' => 'ایمیل وارد شده از قبل وجود دارد',
		],
		'username' => [
			'required' => 'لطفا نام کاربری را وارد کنید',
			'unique' => 'نام کاربری وارد شده از قبل وجود دارد',
		],
		'password' => [
			'required' => 'لطفا کلمه عبور را وارد کنید',
		],
		're_password' => [
			'required' => 'لطفا تکرار کلمه عبور را وارد کنید',
			'match' => 'کلمه عبور با تکرار کلمه عبور باید یکسان باشد',
		],
	],

	//Words
	'words' => [
		'agreed' => 'موافقم',
		'register' => 'ثبت نام',
	],

	//Actions

	//Sentences
	'sentences' => [
		'privacy' => 'سیاست حفظ حریم خصوصی و شرایط',
		'already_have_account' => 'از قبل حساب کاربری دارید؟',
		'login' => 'وارد سیستم شوید',
	],

];