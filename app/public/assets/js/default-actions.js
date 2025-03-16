"use strict";

let deleteModal, approveModal, rejectModal, declineModal;

$(function () {
	//Hide loader
	setTimeout(() => {
		toggleLoader(false);
	}, 300);

	let deleteModalElement = document.getElementById('deleteModal');
	if (deleteModalElement) {
		deleteModal = new bootstrap.Modal(deleteModalElement);
		const btnDelete = document.getElementById('btnDeleteModal');
		btnDelete.addEventListener('click', function () {
			let url = this.getAttribute('data-url');
			axios.delete(url).then((response) => {
				if (typeof rowActionDone === 'function') {
					rowActionDone(true, response.data.message);
				}
				deleteModal.hide();
			}).catch((error) => {
				if (typeof rowActionDone === 'function') {
					if (error.response) {
						rowActionDone(false, error.response.data.message);
					} else {
						rowActionDone(false, lang('admin/global.errors.delete'));
					}
				}
			});
		});
		deleteModalElement.addEventListener('hide.bs.modal', function () {
			btnDelete.removeAttribute('data-url')
		});
	}

	let approveModalElement = document.getElementById('approveModal');
	if (approveModalElement) {
		approveModal = new bootstrap.Modal(approveModalElement);
		const btnApprove = document.getElementById('btnApproveModal');
		btnApprove.addEventListener('click', function () {
			let url = this.getAttribute('data-url');
			axios.patch(url).then((response) => {
				if (typeof rowActionDone === 'function') {
					rowActionDone(true, response.data.message);
				}
				approveModal.hide();
			}).catch((error) => {
				if (typeof rowActionDone === 'function') {
					if (error.response) {
						rowActionDone(false, error.response.data.message);
					} else {
						rowActionDone(false, lang('admin/global.errors.approve'));
					}
				}
			});
		});

		approveModalElement.addEventListener('hide.bs.modal', function () {
			btnApprove.removeAttribute('data-url')
		});
	}

	let rejectModalElement = document.getElementById('rejectModal');
	if (rejectModalElement) {
		rejectModal = new bootstrap.Modal(rejectModalElement);
		const btnReject = document.getElementById('btnRejectModal');
		btnReject.addEventListener('click', function () {
			let url = this.getAttribute('data-url');
			axios.patch(url).then((response) => {
				if (typeof rowActionDone === 'function') {
					rowActionDone(true, response.data.message);
				}
				rejectModal.hide();
			}).catch((error) => {
				if (typeof rowActionDone === 'function') {
					if (error.response) {
						rowActionDone(false, error.response.data.message);
					} else {
						rowActionDone(false, __('admin/global.errors.reject'));
					}
				}
			});
		});
		rejectModalElement.addEventListener('hide.bs.modal', function () {
			btnReject.removeAttribute('data-url')
		});
	}

	let declineModalElement = document.getElementById('declineModal');
	if (declineModalElement) {
		declineModal = new bootstrap.Modal(declineModalElement);
		const btnReject = document.getElementById('btnDeclineModal');
		btnReject.addEventListener('click', function () {
			let declineReason = document.getElementById('declineModalDescription').value;
			if (!declineReason) {
				toastError(__('admin/global.errors.decline_reason.required'));
				return false;
			}
			let url = this.getAttribute('data-url');
			let status = this.getAttribute('data-status');

			const params = {
				decline_reason: declineReason
			};

			if (status !== '') {
				params['status'] = status;
			}

			axios.patch(url, params).then((response) => {
				if (typeof rowActionDone === 'function') {
					rowActionDone(true, response.data.message);
				}
				declineModal.hide();
			}).catch((error) => {
				if (typeof rowActionDone === 'function') {
					if (error.response) {
						rowActionDone(false, error.response.data.message);
					} else {
						rowActionDone(false, __('admin/global.errors.reject'));
					}
				}
			});
		});
		declineModalElement.addEventListener('hide.bs.modal', function () {
			btnReject.removeAttribute('data-url')
		});
	}
});

function deleteItem(element) {
	let url = element.getAttribute('data-url');
	if (url === undefined || url === null || url === '') {
		return;
	}
	document.getElementById('btnDeleteModal').setAttribute('data-url', url);
	deleteModal.show();
}

function approveItem(element) {
	let url = element.getAttribute('data-url');
	if (url === undefined || url === null || url === '') {
		return;
	}
	document.getElementById('btnApproveModal').setAttribute('data-url', url);
	approveModal.show();
}

function rejectItem(element) {
	let url = element.getAttribute('data-url');
	if (url === undefined || url === null || url === '') {
		return;
	}
	document.getElementById('btnRejectModal').setAttribute('data-url', url);
	rejectModal.show();
}

function declineItem(element) {
	let url = element.getAttribute('data-url');
	let status = element.getAttribute('data-status');
	if (url === undefined || url === null || url === '') {
		return;
	}
	const btnRejectModal = document.getElementById('btnDeclineModal');
	btnRejectModal.setAttribute('data-url', url);
	btnRejectModal.setAttribute('data-status', status);
	declineModal.show();
}

function showItem(element) {
	let currentItem = getDataTable().row(element.parentElement.parentElement.parentElement).data();
	document.getElementById('showBody').innerHTML = nl2br(currentItem.decline_reason);

	let showModalElement = document.getElementById('showModal');
	const showModal = new bootstrap.Modal(showModalElement);
	showModal.show();
}

function changeStatusItem(element) {
	const url = element.getAttribute('data-url');
	const status = element.getAttribute('data-status');
	if (url === undefined || url === null || url === '' || status === undefined || status === null || status === '') {
		return;
	}

	axios.patch(url, {status: status}).then((response) => {
		if (typeof rowActionDone === 'function') {
			rowActionDone(true, response.data.message);
		}
	}).catch((error) => {
		if (typeof rowActionDone === 'function') {
			if (error.response) {
				rowActionDone(false, error.response.data.message);
			} else {
				rowActionDone(false, __('admin/global.errors.reject'));
			}
		}
	});
}

function changePriorityItem(element) {
	const url = element.getAttribute('data-url');
	const priority = element.getAttribute('data-priority');
	if (url === undefined || url === null || url === '' || priority === undefined || priority === null || priority === '') {
		return;
	}

	axios.patch(url, {priority: priority}).then((response) => {
		if (typeof rowActionDone === 'function') {
			rowActionDone(true, response.data.message);
		}
	}).catch((error) => {
		if (typeof rowActionDone === 'function') {
			if (error.response) {
				rowActionDone(false, error.response.data.message);
			} else {
				rowActionDone(false, __('admin/global.errors.reject'));
			}
		}
	});
}