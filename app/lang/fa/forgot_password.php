<?php

return [
	'singular' => 'فراموشی کلمه عبور',

	//Fields
	'fields' => [
		'email' => 'ایمیل',
	],

	//Placeholders
	'placeholders' => [
		'email' => 'ایمیل خود را وارد کنید',
	],

	//Errors
	'validations' => [
		'email' => [
			'required' => 'لطفا ایمیل را وارد کنید',
			'invalid' => 'ایمیل وارد شده معتبر نمی باشد',
			'exists' => 'حساب کاربری با ایمیل وارد شده یافت نشد',
		],
	],

	//Words
	'words' => [
		'send_link' => 'ارسال لینک بازنشانی',
		'back_to_login' => 'بازگشت به صفحه ورود',
	],

	//Actions

	//Sentences
	'sentences' => [
		'forgot_password' => 'رمز عبور را فراموش کرده اید؟ 🔒',
		'description' => 'ایمیل خود را وارد کنید و ما دستورالعمل هایی را برای بازنشانی رمز عبور برای شما ارسال می کنیم',
		'user_not_found' => 'حساب کاربری با ایمیل وارد شده یافت نشد',
		'password_link_sent' => 'لینک بازیابی کلمه عبور به ایمیل ارسال شد',
	],

];