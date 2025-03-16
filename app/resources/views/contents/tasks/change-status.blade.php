<div class="btn-group">
	<button type="button" class="btn btn-sm {{ $btnClass }} dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
		<small>{{ $statusText }}</small>
	</button>
	<ul class="dropdown-menu" aria-labelledby="dropDownStatus-{{ $id }}">
		@if($status !== 'complete')
			<li>
				<button type="button" class="dropdown-item" onclick="changeStatusItem(this);" data-status="complete" data-url="{{ $url }}">
					<small>@lang('task.statuses.complete')</small>
				</button>
			</li>
		@endif

		@if($status !== 'incomplete')
			<li>
				<button type="button" class="dropdown-item" onclick="changeStatusItem(this);" data-status="incomplete" data-url="{{ $url }}">
					<small>@lang('task.statuses.incomplete')</small>
				</button>
			</li>
		@endif
	</ul>
</div>