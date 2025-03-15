@if(sizeof($actions) > 3)
	@php
		$chunkActions = array_chunk($actions, 2);
	@endphp

	<div class="d-flex flex-column gap-2">
		@foreach($chunkActions as $actions)
			<div class="d-flex flex-row gap-2">
				@foreach($actions as $action)
					@if($action->isButton)
						<button class="btn btn-light btn-sm" onclick="{{ $action->onClick }}" data-url="{{ route($action->url, $params) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $action->title }}">
							<i class="{{ $action->icon }}"></i>
						</button>
					@else
						<a href="{{ route($action->url, $params) }}" class="btn btn-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $action->title }}">
							<i class="{{ $action->icon }}"></i>
						</a>
					@endif
				@endforeach
			</div>
		@endforeach
	</div>
@else
	<div class="d-flex flex-row gap-2">
		@foreach($actions as $action)
			@if($action->isButton)
				<button class="btn btn-light btn-sm" onclick="{{ $action->onClick }}" data-url="{{ route($action->url, $params) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $action->title }}">
					<i class="{{ $action->icon }}"></i>
				</button>
			@else
				<a href="{{ route($action->url, $params) }}" class="btn btn-light btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $action->title }}">
					<i class="{{ $action->icon }}"></i>
				</a>
			@endif
		@endforeach
	</div>
@endif
