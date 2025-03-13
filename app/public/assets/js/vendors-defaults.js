"use strict";
$(function () {
	$('[data-toggle="select2"]').select2({
		theme: 'bootstrap-5'
	});

	jalaliDatepicker.startWatch({
		hasSecond: false
	});

	perfectScrollBars();

	searchUser();

	handleCopyText();
});

function perfectScrollBars() {
	document.querySelectorAll('[perfect-scroll]').forEach(perfectScrollBarElement => {
		new PerfectScrollbar(perfectScrollBarElement, {
			wheelPropagation: true,
		});
	});
}

function searchUser() {
	document.querySelectorAll('[data-toggle="searchUser"]').forEach(searchUserElement => {
		let mItem = $(searchUserElement);
		let url = mItem.data('url');
		let allowClear = mItem.data('allow-clear') ?? false;

		mItem.select2({
			placeholder: mItem.data('placeholder'),
			allowClear: !!allowClear,
			theme: 'bootstrap-5',
			ajax: {
				url: url,
				method: 'POST',
				delay: 250,
				data: function (params) {
					$.each($(this)[0].dataset, function (index, value) {
						if (index.startsWith('user')) {
							params[index] = value;
						}
					});
					return params;
				},
				processResults: function (data) {
					return {
						results: data
					};
				},

			},
			escapeMarkup: function (markup) {
				return markup;
			},
			minimumInputLength: 1,
			templateResult: formatUserResult,
			templateSelection: formatUserSelection

		});
	});
}

function handleCopyText() {
	$(document).ready(function () {
		const copyElements = document.querySelectorAll('[copy-text]');
		if (copyElements.length > 0) {
			new Clipboard('[copy-text]');
			$('[copy-text]').click(function () {
				$(this).attr('data-bs-original-title', 'کپی شد!').tooltip('show');
				setTimeout(() => {
					$(this).tooltip('hide').attr('data-bs-original-title', 'کپی کن');
				}, 1000);
			});
		}
	});
}

function formatUserResult(repo) {
	if (repo.loading) return repo.text;
	return `<p class="my-1 p-1">${repo.full_name} - ${repo.mobile}</p>`;
}

function formatUserSelection(repo) {
	return repo.full_name || repo.text;
}

function toastSuccess(message) {
	toastr.success(message);
}

function toastError(message) {
	toastr.error(message);
}