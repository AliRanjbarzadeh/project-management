@extends('layouts.auth-master')

@section('auth-content')
	<div class="authentication-wrapper authentication-basic container-p-y">
		<div class="authentication-inner">
			<div class="card">
				<div class="card-body">
					@include('templates.form-validation-messages')

					@include('templates.auth-logo')

					<h4 class="mb-2">@lang('forgot_password.sentences.forgot_password')</h4>
					<p class="mb-4">@lang('forgot_password.sentences.description')</p>
					<form id="formAuthentication" class="mb-3 needs-validation" action="{{ route('login.forgot-password.attempt') }}" method="POST" novalidate>
						@csrf

						<div class="mb-3">
							<label for="email" class="form-label">@lang('forgot_password.fields.email')</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="@lang('forgot_password.placeholders.email')" autofocus required>
						</div>

						<button class="btn btn-primary d-grid w-100">@lang('forgot_password.words.send_link')</button>
					</form>
					<div class="text-center">
						<a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
							<i class="bx bx-chevron-right scaleX-n1-rtl bx-sm"></i> @lang('forgot_password.words.back_to_login')
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('styles')
	<link rel="stylesheet" href="{{ asset("assets/vendor/css/pages/page-auth.css") }}">
@endpush

@push('scripts')
	<script src="{{ asset('assets/vendor/libs/jbvalidator/jbvalidator.min.js') }}"></script>
	<script src="{{ asset('assets/js/components/auth/forgot-password.js') }}?ver={{ $resourceVersion }}"></script>
@endpush