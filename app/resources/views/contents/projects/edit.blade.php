@extends('layouts.dashboard-master')

@section('dashboard-content')
	<form action="{{ route('projects.update', $project) }}" method="post">
		@csrf
		@method('PUT')

		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">@lang('project.actions.edit')</h5>

				<div class="row">
					<div class="mb-3">
						<label for="title" class="form-label">@lang('project.fields.title')</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="@lang('project.placeholders.title')" value="{{ old('title', $project->title) }}"/>
					</div>

					<div class="mb-3">
						<label for="description" class="form-label">@lang('project.fields.description')</label>
						<textarea class="form-control" id="description" name="description" data-toggle="ck-editor" placeholder="@lang('project.placeholders.description')">{{ old('description', $project->description) }}</textarea>
					</div>

					@include('layouts.buttons.btn-update')
				</div>
			</div>
		</div>
	</form>
@endsection

@push('scripts')
	<script type="text/javascript" src="{{ asset('assets/js/ck-editor/index.js') }}?ver={{ $resourceVersion }}"></script>
@endpush