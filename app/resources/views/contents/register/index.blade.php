@extends('layouts.auth-master')

@section('content')
	<div class="authentication-wrapper authentication-basic container-p-y">
		<div class="authentication-inner">
			<div class="card">
				<div class="card-body">
					@include('templates.form-validation-messages')

					@include('templates.auth-logo')

					<h4 class="mb-2">@lang('register.singular')</h4>
					<p class="mb-4">@lang('register.description')</p>

					<form class="mb-3 needs-validation" action="{{ route('register.attempt') }}" method="POST" novalidate>
						@csrf

						<div class="mb-3">
							<label for="full_name" class="form-label">@lang('register.fields.full_name')</label>
							<input type="text" class="form-control" id="full_name" name="full_name" placeholder="@lang('register.placeholders.full_name')" value="{{ old('full_name') }}" autofocus required>
						</div>

						<div class="mb-3">
							<label for="username" class="form-label">@lang('register.fields.username')</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="@lang('register.placeholders.username')" value="{{ old('username') }}" required>
						</div>

						<div class="mb-3">
							<label for="email" class="form-label">@lang('register.fields.email')</label>
							<input type="text" class="form-control" id="email" name="email" placeholder="@lang('register.placeholders.email')" value="{{ old('email') }}" required>
						</div>

						<div class="mb-3 form-password-toggle">
							<label class="form-label" for="password">@lang('register.fields.password')</label>
							<div class="input-group input-group-merge">
								<input type="password" id="password" class="form-control" name="password" placeholder="@lang('register.placeholders.password')" aria-describedby="password" required/>
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<div class="mb-3 form-password-toggle">
							<label class="form-label" for="password_confirmation">@lang('register.fields.password_confirmation')</label>
							<div class="input-group input-group-merge">
								<input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="@lang('register.placeholders.password')" aria-describedby="password" required/>
								<span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
							</div>
						</div>

						<button class="btn btn-primary d-grid w-100">
							@lang('register.words.register')
						</button>
					</form>

					<p class="text-center">
						<span>@lang('register.sentences.already_have_account')</span>
						<a href="{{ route('login') }}">
							<span>@lang('register.sentences.login')</span>
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
	<script src="{{ asset('assets/js/components/register/index.js') }}"></script>
@endpush