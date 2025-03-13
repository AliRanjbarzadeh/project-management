@unless($breadcrumbs->isEmpty())
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb breadcrumb-style1">
			@foreach ($breadcrumbs as $breadcrumb)
				@if(!is_null($breadcrumb->url) && !$loop->last)
					<li class="breadcrumb-item">
						<a href="{{ $breadcrumb->url }}" class="text-gray">{!! $breadcrumb->title !!}</a>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill: #778492;margin-right: 10px;">
							<path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
						</svg>
					</li>
				@elseif(!$loop->last)
					<li class="breadcrumb-item">
						<span class="text-gray">{!! $breadcrumb->title !!}</span>
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill: #778492;margin-right: 10px;">
							<path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
						</svg>
					</li>
				@else
					<li class="breadcrumb-item active text-gray">{!! $breadcrumb->title !!}</li>
				@endif
			@endforeach
		</ol>
	</nav>
@endunless