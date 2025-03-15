@extends('layouts.dashboard-master')

@section('dashboard-content')
	<div class="card">
		<div class="card-body">
			@datatablesTopHead
			{{ $dataTable->table() }}
		</div>
	</div>
@endsection

@push('scripts')
	{{ $dataTable->scripts() }}
	@include('datatables::extra-scripts')
	@if(isset($scripts))
		@foreach($scripts as $script)
			<script type="text/javascript" src="{{ $script }}?ver={{ $resourceVersion }}"></script>
		@endforeach
	@endif
@endpush

@push('modals')
	@if(isset($modals))
		@foreach($modals as $modal => $data)
			@include($modal, $data)
		@endforeach
	@endif
@endpush
