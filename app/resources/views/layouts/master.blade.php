<!DOCTYPE html>
<html lang="fa" class="light-style layout-menu-fixed " dir="rtl" data-theme="theme-default" data-assets-path="{{ public_path("assets/admin/admin") }}/" data-template="vertical-menu-template-free">

<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
	<title>{{ $pageTitle ?? '' }} | @lang('global.app.name')</title>

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{ asset("assets/favicon.png") }}"/>

	<!-- Core CSS -->
	@include('layouts.styles')

	<!-- Page CSS -->
	@stack('styles')

	<!-- Helpers -->
	<script src="{{ asset("assets/vendor/js/helpers.js") }}"></script>
	<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	<script src="{{ asset("assets/js/config.js") }}"></script>
</head>

<body dir="rtl">
@yield('content')

<!-- Core JS -->
@include('layouts.scripts')

<!-- Page JS -->
@stack('scripts')

<!-- Place this tag in your head or just before your close body tag. -->
<script src="{{ asset("assets/vendor/js/buttons.js") }}"></script>

@include('layouts.modals')
@stack('modals')

<div class="loading">
	<div id="loader" class="spinner">
		<div class="spinner-border spinner-border-lg text-info" role="status">
			<span class="visually-hidden">بارگذاری...</span>
		</div>
	</div>
</div>
</body>

</html>