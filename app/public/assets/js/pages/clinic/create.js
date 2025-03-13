$(function () {
	$('#categories').on('change', function () {
		getConsultants($(this).val().map((item) => parseInt(item)));
	});
});


function getConsultants(categoryId) {
	if (categoryId) {
		toggleLoader(true);
		axios.post(route('admin.search.consultantCategory'), {
			categoryId: categoryId
		}).then((response) => {
			if (response.data) {
				renewSelect2Items(response.data, '#consultants', {text: "full_name"}, {placeholder: true, multiple: true});
			}
		}).catch((error) => {
			console.error(error);
		}).finally(() => {
			toggleLoader(false);
		});
	}
}