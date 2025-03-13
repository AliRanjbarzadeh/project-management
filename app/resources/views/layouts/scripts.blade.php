<!-- Jquery -->
<script src="{{ asset("assets/vendor/libs/jquery/jquery.js") }}"></script>
<script type="text/javascript">
	window.baseUrl = '{{ url('') }}';

	//Setup CSRF-TOKEN for ajax
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	function csrfToken() {
		return "{{ csrf_token() }}";
	}

	config = $.extend({}, {
		url: '{{ url('') }}',
		assetUrl: '{{ asset('') }}',
		animationsUrl: '{{ asset('assets/vendor/animations') }}'
	}, config);
</script>

<!-- Core JS -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/popper/popper.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/js/bootstrap.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/js/menu.js") }}"></script>

<!-- Dynamic resources -->
<script type="text/javascript" src="{{ asset("assets/js/translations.js") }}?ver={{ $resourceVersion }}"></script>
<script type="text/javascript" src="{{ asset("assets/js/router.js") }}?ver={{ $resourceVersion }}"></script>

<!-- Vendors JS -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/apex-charts/apexcharts.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/libs/jalali-datepicker/jalalidatepicker.min.js") }}"></script>

<!-- Datatables -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/datatables/datatables.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/libs/datatables/datatables/js/dataTables.bootstrap5.min.js") }}"></script>

<!-- Select2 -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/select2/js/select2.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/libs/select2/js/i18n/fa.js") }}"></script>

<!-- Toastr -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/toastr/toastr.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/libs/toastr/toastr-options.js") }}?ver={{ $resourceVersion }}"></script>

<!-- Axios -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/axios/axios.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("assets/vendor/libs/axios/axios-defaults.js") }}?ver={{ $resourceVersion }}"></script>

<!-- CKEditor -->
<script type="text/javascript" src="{{ asset("assets/vendor/libs/ckeditor/ckeditor.js") }}?ver={{ $resourceVersion }}"></script>

<!-- Dropzone -->
<script type="text/javascript" src="{{ asset('assets/vendor/libs/dropzone/dropzone.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/libs/dropzone/options.js') }}"></script>

<!-- Neshan -->
<script type="text/javascript" src="https://static.neshan.org/sdk/leaflet/v1.9.4/neshan-sdk/v1.0.8/index.js"></script>

<!-- Lodash -->
<script type="text/javascript" src="{{ asset('assets/vendor/js/lodash.min.js') }}"></script>

<!-- Clipboard -->
<script type="text/javascript" src="{{ asset('assets/vendor/libs/clipboard.min.js') }}"></script>

<!-- Lottie -->
<script type="text/javascript" src="{{ asset('assets/vendor/js/lottie.js') }}"></script>

<!-- Main JS -->
<script type="text/javascript" src="{{ asset("assets/js/main.js") }}?ver={{ $resourceVersion }}"></script>
<script type="text/javascript" src="{{ asset("assets/js/default-actions.js") }}?ver={{ $resourceVersion }}"></script>
<script type="text/javascript" src="{{ asset("assets/js/vendors-defaults.js") }}?ver={{ $resourceVersion }}"></script>