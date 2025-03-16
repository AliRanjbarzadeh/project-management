<div class="btn-group">
	<button type="button" class="btn btn-sm {{ $btnClass }} dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
		<small>{{ $priorityText }}</small>
	</button>
	<ul class="dropdown-menu" aria-labelledby="dropDownPriority-{{ $id }}">
		@if($priority !== 'low')
			<li>
				<button type="button" class="dropdown-item" onclick="changePriorityItem(this);" data-priority="low" data-url="{{ $url }}">
					<small>@lang('task.priorities.low')</small>
				</button>
			</li>
		@endif

		@if($priority !== 'medium')
			<li>
				<button type="button" class="dropdown-item" onclick="changePriorityItem(this);" data-priority="medium" data-url="{{ $url }}">
					<small>@lang('task.priorities.medium')</small>
				</button>
			</li>
		@endif

		@if($priority !== 'high')
			<li>
				<button type="button" class="dropdown-item" onclick="changePriorityItem(this);" data-priority="high" data-url="{{ $url }}">
					<small>@lang('task.priorities.high')</small>
				</button>
			</li>
		@endif
	</ul>
</div>