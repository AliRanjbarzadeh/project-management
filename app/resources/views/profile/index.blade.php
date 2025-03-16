@extends('layouts.dashboard-master')

@section('dashboard-content')
	<div class="row">
		<div class="col-md-12">
			<div class="card mb-4">
				<h5 class="card-header">@lang('profile.singular')</h5>
				<div class="card-body">
					<form method="POST" action="{{ route('profile.update') }}">
						@csrf

						<div class="row">
							<div class="mb-3 col-md-4 col-sm-12">
								<label for="full_name" class="form-label">@lang('profile.fields.full_name')</label>
								<input class="form-control" type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}" placeholder="@lang('profile.placeholders.full_name')" autofocus/>
							</div>
							<div class="mb-3 col-md-4 col-sm-12">
								<label for="username" class="form-label">@lang('profile.fields.username')</label>
								<input class="form-control" type="text" id="username" value="{{ $user->username }}" placeholder="@lang('profile.placeholders.username')" readonly/>
							</div>
							<div class="mb-3 col-md-4 col-sm-12">
								<label for="email" class="form-label">@lang('profile.fields.email')</label>
								<input class="form-control" type="text" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="@lang('profile.placeholders.email')"/>
							</div>

							<div class="clearfix"></div>
							@include('layouts.buttons.btn-update')
						</div>
					</form>
				</div>
				<!-- /Account -->
			</div>
		</div>
	</div>
@endsection