"use strict";
$(function () {
	document.querySelector('[data-action="add-phone"]').addEventListener('click', function () {
		let phones = document.getElementById('phones');

		let lastPhone = phones.children.item(phones.childElementCount - 1);
		let phoneId = parseInt(lastPhone.getAttribute('data-phone')) + 1;

		//close other accordions
		for (let i = 1; i < phoneId; i++) {
			let mButton = document.querySelector(`[aria-controls="phone-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-phone="${i}"]`).classList.remove('active');
			document.getElementById(`phone-body-${i}`).classList.remove('show');
		}

		addPhone(phones, phoneId);
	});
});

function deletePhone(element) {
	let phones = document.getElementById('phones');

	let lastPhone = phones.children.item(phones.childElementCount - 1);
	let lastPhoneId = parseInt(lastPhone.getAttribute('data-phone')) + 1;


	let phoneId = parseInt(element.parentElement.parentElement.getAttribute('data-phone'));

	if (phoneId + 1 < lastPhoneId) {
		element.parentElement.parentElement.remove();

		for (let i = phoneId + 1; i < lastPhoneId; i++) {
			let nextPhone = phones.querySelector(`[data-phone="${i}"]`);
			nextPhone.setAttribute('data-phone', (i - 1).toString());

			nextPhone.querySelector(`[id="phone-head-${i}"]`).setAttribute('id', `phone-head-${i - 1}`);

			let nextPhoneBody = nextPhone.querySelector(`[aria-controls="phone-body-${i}"]`);
			nextPhoneBody.setAttribute('data-bs-target', `#phone-body-${i - 1}`);
			nextPhoneBody.setAttribute('aria-controls', `phone-body-${i - 1}`);
			nextPhoneBody.innerText = __('admin/phone.words.title', {'num': i - 1});

			nextPhone.querySelector(`[id="phone-body-${i}"]`).setAttribute('id', `phone-body-${i - 1}`);

			nextPhone.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextPhone.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextPhone.querySelector(`[for="phone-${i}"]`).setAttribute('for', `phone-${i - 1}`);
			nextPhone.querySelector(`[id="phone-${i}"]`).setAttribute('id', `phone-${i - 1}`);
		}
	} else {
		if (phoneId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addPhone(phoneContainer, phoneId) {
	let phoneElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-phone', value: phoneId},
		]
	});

	//head
	let phoneHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `phone-head-${phoneId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	phoneElement.appendChild(phoneHeadElement);

	//delete button
	let phoneDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deletePhone(this)'},
		]
	});
	// phoneDeleteButton.addEventListener('click', deletePhone(phoneDeleteButton));
	phoneHeadElement.appendChild(phoneDeleteButton);

	//delete icon
	let phoneDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	phoneDeleteButton.appendChild(phoneDeleteIcon);

	//accordion button
	let phoneAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/phone.words.title', {'num': phoneId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#phone-body-${phoneId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `phone-body-${phoneId}`},
		],
	});
	phoneHeadElement.appendChild(phoneAccordionButton);

	//accordion collapse
	let phoneAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `phone-body-${phoneId}`},
		],
	});
	phoneElement.appendChild(phoneAccordionCollapse);

	//accordion body
	let phoneAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	phoneAccordionCollapse.appendChild(phoneAccordionBody);

	//title div
	let phoneTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	phoneAccordionBody.appendChild(phoneTitleDiv);

	//title label
	let phoneTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/phone.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${phoneId}`},
		],
	});
	phoneTitleDiv.appendChild(phoneTitleLabel);

	//title input
	let phoneTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${phoneId}`},
			{name: 'name', value: 'phones[title][]'},
			{name: 'placeholder', value: __('admin/phone.placeholders.title')},
		]
	});
	phoneTitleDiv.appendChild(phoneTitleInput);

	//phone div
	let phonePhoneDiv = mCreateElement({
		element: 'div',
	});
	phoneAccordionBody.appendChild(phonePhoneDiv);

	//phone label
	let phonePhoneLabel = mCreateElement({
		element: 'label',
		text: __('admin/phone.fields.phone'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `phone-${phoneId}`},
		],
	});
	phonePhoneDiv.appendChild(phonePhoneLabel);

	//phone input
	let phonePhoneInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `phone-${phoneId}`},
			{name: 'name', value: 'phones[phone][]'},
			{name: 'data-type', value: 'number'},
			{name: 'placeholder', value: __('admin/phone.placeholders.phone')},
		]
	});
	phonePhoneDiv.appendChild(phonePhoneInput);

	//id
	let phoneIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'phones[id][]'},
		]
	});
	phoneElement.appendChild(phoneIdInput);

	phoneContainer.appendChild(phoneElement);
	handleInputs();
}