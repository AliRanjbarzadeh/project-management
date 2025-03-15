@extends('layouts.auth-master')

@section('content')
	<div class="authentication-wrapper authentication-basic container-p-y">
		<div class="authentication-inner">
			<div class="card">
				<div class="card-body">
					@include('templates.form-validation-messages')

					@include('templates.auth-logo')

					<h4 class="mb-2">@lang('auth.title')</h4>
					<p class="mb-4">@lang('auth.description')</p>

					@error('message')
					<div class="alert alert-danger alert-dismissible" role="alert">
						{{ $message }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
					@enderror

					<form class="mb-3 needs-validation" action="{{ route('login.attempt') }}" method="POST" novalidate>
						@method('POST')
						@csrf

						<div class="mb-3">
							<label for="username" class="form-label">@lang('auth.fields.username')</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="@lang('auth.placeholders.username')" value="{{ old('username') }}" autofocus required>
						</div>

						<div class="mb-3 form-password-toggle">
							<div class="d-flex justify-content-between">
								<label class="form-label" for="password">@lang('auth.fields.password')</label>
								<a href="{{ route('login.forgot-password.index') }}">
									<small>@lang('auth.sentences.forgot_password')</small>
								</a>
							</div>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password" placeholder="@lang('auth.placeholders.password')" aria-describedby="password" required/>
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<div class="mb-3">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="remember-me" name="remember">
								<label class="form-check-label" for="remember-me">@lang('auth.fields.remember_me')</label>
							</div>
						</div>
						<div class="mb-3">
							<button class="btn btn-primary d-grid w-100" type="submit">@lang('auth.buttons.login')</button>
						</div>
					</form>
					<p class="text-center">
						<span>@lang('auth.sentences.new_user')</span>
						<a href="{{ route('register.index') }}">
							<span>@lang('auth.sentences.register')</span>
						</a>
					</p>
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
	<script src="{{ asset('assets/js/components/auth/index.js') }}?ver={{ $resourceVersion }}"></script>
@endpush