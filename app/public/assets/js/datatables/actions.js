"use strict";

function updatePriority(button) {
	let priorityInputs = document.querySelectorAll('[data-input="priority"]');

	let priorities = [];
	for (const priorityInput of priorityInputs) {
		priorities.push({
			id: parseInt(priorityInput.getAttribute('data-id')),
			priority: parseInt(priorityInput.value),
		});
	}

	const url = button.getAttribute('data-url');
	const model = button.getAttribute('data-model');

	axios.post(url, {
		priorities: priorities,
		model: model
	}).then(response => {
		toastSuccess(response.data.message);
		if (typeof redrawDatatable === 'function') {
			redrawDatatable();
		}
	}).catch(error => {
		if (error.response) {
			toastError(error.response.data.message);
		} else {
			toastError(__('admin/global.errors.update'))
		}
	});
}