<div class="row g-3 align-items-center mb-3">
	@foreach($inputs as $input)
		<div class="col-auto">
			<label for="filterInput{{ ucfirst($input['name']) }}" class="col-form-label">{{ $input['title'] }}</label>
			@switch($input['type'])
				@case('text')
					<input type="{{ $input['type'] }}" id="filterInput{{ ucfirst($input['name']) }}" data-type="{{ $input['type'] }}" data-field="{{ $input['name'] }}" class="form-control" placeholder="{{ $input['title'] }}">
					@break

				@case('number')
					<input type="text" id="filterInput{{ ucfirst($input['name']) }}" data-type="{{ $input['type'] }}" data-field="{{ $input['name'] }}" class="form-control" placeholder="{{ $input['title'] }}">
					@break

				@case('date')
					<div class="input-group">
						<input id="filterInputFrom{{ ucfirst($input['name']) }}" data-field="from_{{ $input['name'] }}" data-type="{{ $input['type'] }}" class="form-control" placeholder="@lang('global.placeholders.date')" data-jdp data-jdp-only-date readonly>
						<span class="input-group-text">@lang('global.words.until')</span>
						<input id="filterInputTo{{ ucfirst($input['name']) }}" data-field="to_{{ $input['name'] }}" data-type="{{ $input['type'] }}" class="form-control" placeholder="@lang('global.placeholders.date')" data-jdp data-jdp-only-date readonly>
					</div>
					@break

				@case('status')
				@case('dropdown')
					@if(isset($dropdowns[$input['name']]))
						<select id="filterInput{{ ucfirst($input['name']) }}" data-type="{{ $input['type'] }}" data-field="{{ $input['name'] }}" class="select2 w-px-200" data-toggle="select2" data-allow-clear="true" data-minimum-results-for-search="-1" data-placeholder="{{ $input['title'] }}">
							<option></option>
							@foreach($dropdowns[$input['name']] as $key => $name)
								<option value="{{ $key }}">{{ $name }}</option>
							@endforeach
						</select>
					@endif
					@break
			@endswitch
		</div>
	@endforeach
</div>

@if(!empty($actionButtons))
	<div class="row mb-3">
		@foreach($actionButtons as $actionButton)
			<div class="col-auto mb-2 mb-lg-0">
				@if($actionButton->isButton)
					<button type="button" id="filterButton{{ $loop->iteration }}" class="btn {{ $actionButton->htmlClass }}" data-action="{{ $actionButton->jsMethod }}" @if($actionButton->isHasUrl()) data-url="{{ $actionButton->url }}" data-model="{{ $actionButton->modelName }}" @endif>
						<i class="{{ $actionButton->icon }} me-1"></i>{{ $actionButton->title }}
					</button>
				@else
					<a href="{{ $actionButton->url }}" id="filterButton{{ $loop->iteration }}" class="btn {{ $actionButton->htmlClass }}" target="{{ $actionButton->target }}">
						<i class="{{ $actionButton->icon }} me-1"></i>{{ $actionButton->title }}
					</a>
				@endif
			</div>
		@endforeach
	</div>
@endif

@if(!empty($actionLinks))
	<div class="row mb-3">
		@foreach($actionLinks as $actionLink)
			<div class="col-auto mb-2 mb-lg-0">
				@if($actionLink->isButton)
					<button type="button" id="filterButton{{ $loop->iteration }}" class="btn {{ $actionLink->htmlClass }}" data-action="{{ $actionLink->jsMethod }}" @if($actionLink->isHasUrl()) data-url="{{ $actionLink->url }}" data-model="{{ $actionLink->modelName }}" @endif>
						<i class="{{ $actionLink->icon }} me-1"></i>{{ $actionLink->title }}
					</button>
				@else
					<a href="{{ $actionLink->url }}" id="filterButton{{ $loop->iteration }}" class="btn {{ $actionLink->htmlClass }}" target="{{ $actionLink->target }}">
						<i class="{{ $actionLink->icon }} me-1"></i>{{ $actionLink->title }}
					</a>
				@endif
			</div>
		@endforeach
	</div>
@endif
