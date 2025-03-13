@extends('layouts.master')

@section('content')
	<div class="container-xxl container-p-y">
		<div class="misc-wrapper">
			<h2 class="mb-2 mx-2">صفحه پیدا نشد :(</h2>
			<p class="mb-4 mx-2">😖خطا! آدرس درخواستی در این سرور یافت نشد</p>
			<a href="{{ route('index') }}" class="btn btn-primary">برگشت به خانه</a>
			<div class="mt-3">
				<img src="{{ asset('assets/img/illustrations/page-misc-error-light.png') }}" alt="page-misc-error-light" width="500" class="img-fluid" data-app-dark-img="illustrations/page-misc-error-dark.png" data-app-light-img="illustrations/page-misc-error-light.png">
			</div>
		</div>
	</div>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-misc.css') }}">
@endpush
