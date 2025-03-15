@extends('layouts.auth-master')

@section('content')
	<div class="authentication-wrapper authentication-basic container-p-y">
		<div class="authentication-inner">
			<div class="card">
				<div class="card-body">
					@include('templates.form-validation-messages')

					@include('templates.auth-logo')

					<h4 class="mb-2">@lang('reset_password.singular')</h4>
					<p class="mb-4">@lang('reset_password.description')</p>
					<form id="formAuthentication" class="mb-3 needs-validation" action="{{ route('reset-password.attempt') }}" method="POST" novalidate>
						@csrf
						<input type="hidden" name="token" value="{{ $token }}">

						<div class="mb-3">
							<label for="email" class="form-label">@lang('reset_password.fields.email')</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="@lang('reset_password.placeholders.email')">
						</div>

						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password">@lang('reset_password.fields.password')</label>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password" placeholder="@lang('reset_password.placeholders.password')" aria-describedby="password" required/>
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password_confirmation">@lang('reset_password.fields.password_confirmation')</label>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="@lang('reset_password.placeholders.password')" aria-describedby="password" required/>
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<button class="btn btn-primary d-grid w-100">@lang('reset_password.actions.reset_password')</button>
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
	<script src="{{ asset('assets/js/components/auth/reset-password.js') }}?ver={{ $resourceVersion }}"></script>
@endpush