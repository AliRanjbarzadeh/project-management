<div class="btn-group">
	<button type="button" class="btn btn-sm @if($status) btn-success @else btn-danger @endif dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
		<small>@lang('admin/status.fields.' . $status)</small>
	</button>
	<ul class="dropdown-menu" aria-labelledby="dropDownConsultant-{{ $id }}">
		<li>
			<button type="button" class="dropdown-item" onclick="changeStatusItem(this);" data-status="{{ 1 - $status }}" data-url="{{ $url }}" data-part="{{ $part }}">
				<small>
					@if($status === 1)
						@lang('admin/status.actions.disable')
					@else
						@lang('admin/status.actions.activate')
					@endif
				</small>
			</button>
		</li>
	</ul>
</div>