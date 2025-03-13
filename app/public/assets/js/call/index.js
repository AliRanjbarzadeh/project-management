"use strict";

let mValidator;

function transferCall(element) {
	const url = element.getAttribute("data-url");

	axios.get(url)
		.then(response => {
			console.log(response.data);
			const userCall = response.data.userCall;
			const consultants = response.data.consultants;
			if (consultants.length > 0) {
				showTransferCallModal(consultants, userCall);
			} else {
				toastError(__('admin/consultant.errors.no_item_for_transfer', {name: __('admin/call.singular')}));
			}
		}).catch(error => {});
}

function showTransferCallModal(consultants, userCall) {
	let transferForm = document.getElementById('transferForm');
	transferForm.setAttribute('action', route('admin.userCalls.transfer.store', {userCall: userCall.id}));

	let currentPrice = document.getElementById('currentPrice');
	currentPrice.innerText = __('admin/transfer.words.call.current_price', {price: number_format(userCall.price)});

	let consultantPrice = document.getElementById('consultantPrice');
	let priceWarning = document.getElementById('priceWarning');

	let callTransferModalElement = document.getElementById('callTransferModal');
	if (callTransferModalElement) {
		const mSelect = document.getElementById('user_id');

		consultants.forEach(consultant => {
			const mOption = document.createElement('option');
			mOption.value = consultant.id;
			mOption.text = consultant.fullname;

			mSelect.appendChild(mOption);
		});


		callTransferModalElement.addEventListener('hide.bs.modal', function () {
			mSelect.innerHTML = '<option></option>';
			currentPrice.innerText = '';
			consultantPrice.innerText = '';

			priceWarning.classList.add('d-none');
		});

		callTransferModalElement.addEventListener('shown.bs.modal', function () {
			mValidator = $('form#transferForm').jbvalidator({
				errorMessage: true,
				successClass: true,
				language: config.assetUrl + 'assets/vendor/libs/jbvalidator/lang/fa.json'
			});
		});

		$(mSelect).on('change', function () {
			const mConsultant = consultants.find(consultant => parseInt(consultant.id) === parseInt(mSelect.value));
			const planPrice = mConsultant.plan.prices.find(price => parseInt(price.category_item_id) === parseInt(CategoryPrice.Call));
			consultantPrice.innerText = __('admin/transfer.words.call.new_price', {price: number_format(planPrice.price)});

			if (parseInt(userCall.price) < parseInt(planPrice.price)) {
				priceWarning.innerText = __('admin/transfer.sentences.warning', {price: number_format(parseInt(planPrice.price) - parseInt(userCall.price))})
				priceWarning.classList.remove('d-none');
			}
		});

		const callTransferModal = new bootstrap.Modal(callTransferModalElement);
		callTransferModal.show();
	}
}


function declineCall(element) {
	const url = element.getAttribute("data-url");
	let declineForm = document.getElementById('declineForm');
	declineForm.setAttribute('action', url);

	let callDeclineModalElement = document.getElementById('callDeclineModal');
	let rollbackWallet = document.getElementById('rollback_wallet');

	callDeclineModalElement.addEventListener('hide.bs.modal', function () {
		rollbackWallet.selectedIndex = -1;
		rollbackWallet.dispatchEvent(new Event('change'));
	});

	callDeclineModalElement.addEventListener('shown.bs.modal', function () {
		mValidator = $('form#declineForm').jbvalidator({
			errorMessage: true,
			successClass: true,
			language: config.assetUrl + 'assets/vendor/libs/jbvalidator/lang/fa.json'
		});
	});

	const callDeclineModal = new bootstrap.Modal(callDeclineModalElement);
	callDeclineModal.show();
}


function endCall(element) {
	const url = element.getAttribute("data-url");
	let endForm = document.getElementById('endForm');
	endForm.setAttribute('action', url);

	let callEndModalElement = document.getElementById('callEndModal');
	const callEndModal = new bootstrap.Modal(callEndModalElement);
	callEndModal.show();
}