@extends('layouts.dashboard-master')

@section('dashboard-content')
	<form action="{{ route('projects.tasks.update', [$project, $task]) }}" method="post">
		@csrf
		@method('PUT')

		<div class="card mb-3">
			<div class="card-body">
				<h5 class="card-title">@lang('task.actions.edit')</h5>

				<div class="row">

					<div class="col-md-3 col-sm-12 mb-3">
						<label for="title" class="form-label">@lang('task.fields.title')</label>
						<input type="text" class="form-control" id="title" name="title" placeholder="@lang('task.placeholders.title')" value="{{ old('title', $task->title) }}"/>
					</div>

					<div class="col-md-3 col-sm-12 mb-3">
						<label for="due_date" class="form-label">@lang('task.fields.due_date')</label>
						<input type="text" class="form-control" id="due_date" name="due_date" placeholder="@lang('global.placeholders.date')" value="{{ old('due_date', $task->due_date_jalali) }}" data-jdp data-jdp-only-date/>
					</div>

					<div class="col-md-3 col-sm-12 mb-3">
						<label for="deadline" class="form-label">@lang('task.fields.deadline')</label>
						<input type="text" class="form-control" id="deadline" name="deadline" placeholder="@lang('global.placeholders.date')" value="{{ old('deadline', $task->deadline_jalali) }}" data-jdp data-jdp-only-date/>
					</div>

					<div class="col-md-3 mb-3">
						<label for="priority" class="form-label">@lang('task.fields.priority')</label>
						<select id="priority" name="priority" class="w-100" data-toggle="select2" data-placeholder="@lang('global.words.choose')">
							<option></option>
							<option value="low" @selected(old('priority', $task->priority) == 'low')>@lang('task.priorities.low')</option>
							<option value="medium" @selected(old('priority', $task->priority) == 'medium')>@lang('task.priorities.medium')</option>
							<option value="high" @selected(old('priority', $task->priority) == 'high')>@lang('task.priorities.high')</option>
						</select>
					</div>

					<div class="col-md-12 mb-3">
						<label for="description" class="form-label">@lang('task.fields.description')</label>
						<textarea class="form-control" id="description" name="description" data-toggle="ck-editor" placeholder="@lang('task.placeholders.description')">{{ old('description', $task->description) }}</textarea>
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