"use strict";
$(function () {
	document.querySelector('[data-action="add-contact"]').addEventListener('click', function () {
		let contacts = document.getElementById('contacts');

		let lastContact = contacts.children.item(contacts.childElementCount - 1);
		let contactId = parseInt(lastContact.getAttribute('data-contact')) + 1;

		//close other accordions
		for (let i = 1; i < contactId; i++) {
			let mButton = document.querySelector(`[aria-controls="contact-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-contact="${i}"]`).classList.remove('active');
			document.getElementById(`contact-body-${i}`).classList.remove('show');
		}

		addContact(contacts, contactId);
	});
});

function deleteContact(element) {
	let contacts = document.getElementById('contacts');

	let lastContact = contacts.children.item(contacts.childElementCount - 1);
	let lastContactId = parseInt(lastContact.getAttribute('data-contact')) + 1;
	let contactId = parseInt(element.parentElement.parentElement.getAttribute('data-contact'));

	if (contactId + 1 < lastContactId) {
		element.parentElement.parentElement.remove();

		for (let i = contactId + 1; i < lastContactId; i++) {
			let nextContact = contacts.querySelector(`[data-contact="${i}"]`);
			nextContact.setAttribute('data-contact', (i - 1).toString());

			nextContact.querySelector(`[id="contact-head-${i}"]`).setAttribute('id', `contact-head-${i - 1}`);

			let nextContactBody = nextContact.querySelector(`[aria-controls="contact-body-${i}"]`);
			nextContactBody.setAttribute('data-bs-target', `#contact-body-${i - 1}`);
			nextContactBody.setAttribute('aria-controls', `contact-body-${i - 1}`);
			nextContactBody.innerText = __('admin/contact.words.contact', {'num': i - 1});

			nextContact.querySelector(`[id="contact-body-${i}"]`).setAttribute('id', `contact-body-${i - 1}`);

			nextContact.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextContact.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextContact.querySelector(`[for="value-${i}"]`).setAttribute('for', `value-${i - 1}`);
			nextContact.querySelector(`[id="value-${i}"]`).setAttribute('id', `value-${i - 1}`);
		}
	} else {
		if (contactId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addContact(contactContainer, contactId) {
	let contactElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-contact', value: contactId},
		]
	});

	//head
	let contactHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `contact-head-${contactId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	contactElement.appendChild(contactHeadElement);

	//delete button
	let contactDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteContact(this)'},
		]
	});
	contactHeadElement.appendChild(contactDeleteButton);

	//delete icon
	let contactDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	contactDeleteButton.appendChild(contactDeleteIcon);

	//accordion button
	let contactAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/contact.words.contact', {'num': contactId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#contact-body-${contactId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `contact-body-${contactId}`},
		],
	});
	contactHeadElement.appendChild(contactAccordionButton);

	//accordion collapse
	let contactAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `contact-body-${contactId}`},
		],
	});
	contactElement.appendChild(contactAccordionCollapse);

	//accordion body
	let contactAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	contactAccordionCollapse.appendChild(contactAccordionBody);

	//title div
	let contactTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	contactAccordionBody.appendChild(contactTitleDiv);

	//title label
	let contactTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/contact.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${contactId}`},
		],
	});
	contactTitleDiv.appendChild(contactTitleLabel);

	//title input
	let contactTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${contactId}`},
			{name: 'name', value: 'contact[title][]'},
			{name: 'placeholder', value: __('admin/contact.placeholders.title')},
		]
	});
	contactTitleDiv.appendChild(contactTitleInput);

	//value div
	let contactValueDiv = mCreateElement({
		element: 'div',
	});
	contactAccordionBody.appendChild(contactValueDiv);

	//value label
	let contactValueLabel = mCreateElement({
		element: 'label',
		text: __('admin/contact.fields.value'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `value-${contactId}`},
		],
	});
	contactValueDiv.appendChild(contactValueLabel);

	//value input
	let contactValueInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `value-${contactId}`},
			{name: 'name', value: 'contact[value][]'},
			{name: 'placeholder', value: __('admin/contact.placeholders.value')},
		]
	});
	contactValueDiv.appendChild(contactValueInput);

	//id
	let contactIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'contact[id][]'},
		]
	});
	contactElement.appendChild(contactIdInput);

	contactContainer.appendChild(contactElement);
}