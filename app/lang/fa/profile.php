<?php

return [
	'singular' => 'پروفایل من',

	//Fields
	'fields' => [
		'full_name' => 'نام و نام خانوادگی',
		'username' => 'نام کاربری',
		'email' => 'ایمیل',
	],

	//Placeholders
	'placeholders' => [
		'full_name' => 'نام و نام خانوادگی خود را وارد کنید',
		'email' => 'ایمیل  خود را وارد کنید',
		'username' => 'نام کاربری  خود را وارد کنید',
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
			'max' => 'طول ایمیل نباید بیشتر از 100 کاراکتر باشد',
		],
		'password' => [
			'required' => 'لطفا کلمه عبور را وارد کنید',
		],
	],

	//Words

	//Actions

	//Sentences
	'sentences' => [
		'success' => 'پروفایل با موفقیت بروزرسانی شد',
		'error' => 'بروزرسانی نشد، لطفا مجددا تلاش کنید',
	],

];