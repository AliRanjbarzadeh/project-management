@extends('layouts.dashboard-master')

@section('dashboard-content')
	<form action="{{ route('projects.store') }}" method="post">
		@csrf

		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">@lang('project.actions.create')</h5>

				<div class="row">
					<div class="mb-3">
						<label for="title" class="form-label">@lang('project.fields.title')</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="@lang('project.placeholders.title')" value="{{ old('title') }}"/>
					</div>

					<div class="mb-3">
						<label for="description" class="form-label">@lang('project.fields.description')</label>
						<textarea class="form-control" id="description" name="description" data-toggle="ck-editor" placeholder="@lang('project.placeholders.description')">{{ old('description') }}</textarea>
					</div>

					@include('layouts.buttons.btn-create')
				</div>
			</div>
		</div>
	</form>
@endsection

@push('scripts')
	<script type="text/javascript" src="{{ asset('assets/js/ck-editor/index.js') }}?ver={{ $resourceVersion }}"></script>
@endpush