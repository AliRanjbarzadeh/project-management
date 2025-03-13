@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-12">
			<form action="{{ route('admins.update', $admin) }}" method="post" enctype="multipart/form-data">
				@csrf
				@method('PATCH')

				<div class="row">
					<div class="col-md-8">
						<div class="card mb-3">
							<div class="card-body">
								<h5 class="card-title">@lang('global.words.basic_information')</h5>

								<div class="row">
									<div class="col-md-4 mb-3">
										<label for="firstname" class="form-label">@lang('admin.fields.firstname')</label>
										<input type="text" class="form-control" id="firstname" name="firstname" placeholder="@lang('admin.placeholders.firstname')" value="{{ old('firstname', $admin->firstname) }}"/>
									</div>

									<div class="col-md-4 mb-3">
										<label for="lastname" class="form-label">@lang('admin.fields.lastname')</label>
										<input type="text" class="form-control" id="lastname" name="lastname" placeholder="@lang('admin.placeholders.lastname')" value="{{ old('lastname', $admin->lastname) }}"/>
									</div>

									<div class="col-md-4 mb-3">
										<label for="contact_number" class="form-label">@lang('admin.fields.contact_number')</label>
										<input type="text" class="form-control" id="contact_number" name="contact_number" placeholder="@lang('admin.placeholders.contact_number')" value="{{ old('contact_number', $admin->contact_number) }}" data-type="number"/>
									</div>
								</div>

								<div class="row">
									<div class="col-md-4 mb-3">
										<label for="username" class="form-label">@lang('admin.fields.username')</label>
										<input type="text" class="form-control" id="username" name="username" placeholder="@lang('admin.placeholders.username')" value="{{ old('username', $admin->username) }}" disabled/>
									</div>

									<div class="col-md-4 mb-3">
										<label for="password" class="form-label">@lang('admin.fields.password')</label>
										<input type="password" class="form-control" id="password" name="password" placeholder="@lang('admin.placeholders.password')" autocomplete="new-password"/>
									</div>

									<div class="col-md-4 mb-3">
										<label for="re_password" class="form-label">@lang('admin.fields.re_password')</label>
										<input type="password" class="form-control" id="re_password" name="re_password" placeholder="@lang('admin.placeholders.re_password')" autocomplete="new-password"/>
									</div>
								</div>

								<button type="submit" class="btn btn-primary mt-3 w-25">
									<span class="tf-icon bx bx-refresh"></span>
									@lang('global.actions.update')
								</button>
							</div>
						</div>
					</div>

					<!--Sidebar tools-->
					<div class="col-md-4">
						<!--Feature Image-->
						@include('templates.feature-image', ['featureImage' => $admin->getMediumByName('profile')])

						<!--Roles-->
						<div class="card">
							<div class="card-body">
								<label for="role_id" class="form-label">@lang('role.singular')</label>
								<select id="role_id" name="role_id" class="select2 w-100" data-toggle="select2" data-placeholder="@lang('global.words.choose')">
									<option></option>
									@foreach($roles as $role)
										<option value="{{ $role->id }}" @selected(old('role_id', $admin->role_id) == $role->id)>{{ $role->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
@endsection