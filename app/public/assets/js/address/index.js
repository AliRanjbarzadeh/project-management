"use strict";
$(function () {
	document.querySelector('[data-action="add-address"]').addEventListener('click', function () {
		let addresses = document.getElementById('addresses');

		let lastAddress = addresses.children.item(addresses.childElementCount - 1);
		let addressId = parseInt(lastAddress.getAttribute('data-address')) + 1;

		//close other accordions
		for (let i = 1; i < addressId; i++) {
			let mButton = document.querySelector(`[aria-controls="address-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-address="${i}"]`).classList.remove('active');
			document.getElementById(`address-body-${i}`).classList.remove('show');
		}

		addAddress(addresses, addressId);
	});
});

function deleteAddress(element) {
	let addresses = document.getElementById('addresses');

	let lastAddress = addresses.children.item(addresses.childElementCount - 1);
	let lastAddressId = parseInt(lastAddress.getAttribute('data-address')) + 1;


	let addressId = parseInt(element.parentElement.parentElement.getAttribute('data-address'));

	if (addressId + 1 < lastAddressId) {
		element.parentElement.parentElement.remove();

		for (let i = addressId + 1; i < lastAddressId; i++) {
			let nextAddress = addresses.querySelector(`[data-address="${i}"]`);
			nextAddress.setAttribute('data-address', (i - 1).toString());

			nextAddress.querySelector(`[id="address-head-${i}"]`).setAttribute('id', `address-head-${i - 1}`);

			let nextAddressBody = nextAddress.querySelector(`[aria-controls="address-body-${i}"]`);
			nextAddressBody.setAttribute('data-bs-target', `#address-body-${i - 1}`);
			nextAddressBody.setAttribute('aria-controls', `address-body-${i - 1}`);
			nextAddressBody.innerText = __('admin/address.words.title', {'num': i - 1});

			nextAddress.querySelector(`[id="address-body-${i}"]`).setAttribute('id', `address-body-${i - 1}`);

			nextAddress.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextAddress.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextAddress.querySelector(`[for="address-${i}"]`).setAttribute('for', `address-${i - 1}`);
			nextAddress.querySelector(`[id="address-${i}"]`).setAttribute('id', `address-${i - 1}`);
		}
	} else {
		if (addressId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addAddress(addressContainer, addressId) {
	let addressElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-address', value: addressId},
		]
	});

	//head
	let addressHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `address-head-${addressId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	addressElement.appendChild(addressHeadElement);

	//delete button
	let addressDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteAddress(this)'},
		]
	});
	addressHeadElement.appendChild(addressDeleteButton);

	//delete icon
	let addressDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	addressDeleteButton.appendChild(addressDeleteIcon);

	//accordion button
	let addressAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/address.words.title', {'num': addressId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#address-body-${addressId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `address-body-${addressId}`},
		],
	});
	addressHeadElement.appendChild(addressAccordionButton);

	//accordion collapse
	let addressAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `address-body-${addressId}`},
		],
	});
	addressElement.appendChild(addressAccordionCollapse);

	//accordion body
	let addressAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	addressAccordionCollapse.appendChild(addressAccordionBody);

	//title div
	let addressTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	addressAccordionBody.appendChild(addressTitleDiv);

	//title label
	let addressTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/address.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${addressId}`},
		],
	});
	addressTitleDiv.appendChild(addressTitleLabel);

	//title input
	let addressTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${addressId}`},
			{name: 'name', value: 'addresses[title][]'},
			{name: 'placeholder', value: __('admin/address.placeholders.title')},
		]
	});
	addressTitleDiv.appendChild(addressTitleInput);

	//phone div
	let addressAddressDiv = mCreateElement({
		element: 'div',
	});
	addressAccordionBody.appendChild(addressAddressDiv);

	//phone label
	let addressAddressabel = mCreateElement({
		element: 'label',
		text: __('admin/address.fields.address'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `address-${addressId}`},
		],
	});
	addressAddressDiv.appendChild(addressAddressabel);

	//phone input
	let addressAddressInput = mCreateElement({
		element: 'textarea',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `address-${addressId}`},
			{name: 'name', value: 'addresses[phone][]'},
			{name: 'rows', value: '3'},
			{name: 'placeholder', value: __('admin/address.placeholders.address')},
		]
	});
	addressAddressDiv.appendChild(addressAddressInput);

	//id
	let addressIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'addresses[id][]'},
		]
	});
	addressElement.appendChild(addressIdInput);

	addressContainer.appendChild(addressElement);
}