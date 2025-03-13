"use strict";
$(function () {
	document.querySelector('[data-action="add-email"]').addEventListener('click', function () {
		let emails = document.getElementById('emails');

		let lastEmail = emails.children.item(emails.childElementCount - 1);
		let emailId = parseInt(lastEmail.getAttribute('data-email')) + 1;

		//close other accordions
		for (let i = 1; i < emailId; i++) {
			let mButton = document.querySelector(`[aria-controls="email-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-email="${i}"]`).classList.remove('active');
			document.getElementById(`email-body-${i}`).classList.remove('show');
		}

		addEmail(emails, emailId);
	});
});

function deleteEmail(element) {
	let emails = document.getElementById('emails');

	let lastEmail = emails.children.item(emails.childElementCount - 1);
	let lastEmailId = parseInt(lastEmail.getAttribute('data-email')) + 1;


	let emailId = parseInt(element.parentElement.parentElement.getAttribute('data-email'));

	if (emailId + 1 < lastEmailId) {
		element.parentElement.parentElement.remove();

		for (let i = emailId + 1; i < lastEmailId; i++) {
			let nextEmail = emails.querySelector(`[data-email="${i}"]`);
			nextEmail.setAttribute('data-email', (i - 1).toString());

			nextEmail.querySelector(`[id="email-head-${i}"]`).setAttribute('id', `email-head-${i - 1}`);

			let nextEmailBody = nextEmail.querySelector(`[aria-controls="email-body-${i}"]`);
			nextEmailBody.setAttribute('data-bs-target', `#email-body-${i - 1}`);
			nextEmailBody.setAttribute('aria-controls', `email-body-${i - 1}`);
			nextEmailBody.innerText = __('admin/email.words.title', {'num': i - 1});

			nextEmail.querySelector(`[id="email-body-${i}"]`).setAttribute('id', `email-body-${i - 1}`);

			nextEmail.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextEmail.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextEmail.querySelector(`[for="email-${i}"]`).setAttribute('for', `email-${i - 1}`);
			nextEmail.querySelector(`[id="email-${i}"]`).setAttribute('id', `email-${i - 1}`);
		}
	} else {
		if (emailId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addEmail(emailContainer, emailId) {
	let emailElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-email', value: emailId},
		]
	});

	//head
	let emailHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `email-head-${emailId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	emailElement.appendChild(emailHeadElement);

	//delete button
	let emailDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteEmail(this)'},
		]
	});
	emailHeadElement.appendChild(emailDeleteButton);

	//delete icon
	let emailDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	emailDeleteButton.appendChild(emailDeleteIcon);

	//accordion button
	let emailAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/email.words.title', {'num': emailId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#email-body-${emailId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `email-body-${emailId}`},
		],
	});
	emailHeadElement.appendChild(emailAccordionButton);

	//accordion collapse
	let emailAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `email-body-${emailId}`},
		],
	});
	emailElement.appendChild(emailAccordionCollapse);

	//accordion body
	let emailAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	emailAccordionCollapse.appendChild(emailAccordionBody);

	//title div
	let emailTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	emailAccordionBody.appendChild(emailTitleDiv);

	//title label
	let emailTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/email.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${emailId}`},
		],
	});
	emailTitleDiv.appendChild(emailTitleLabel);

	//title input
	let emailTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${emailId}`},
			{name: 'name', value: 'emails[title][]'},
			{name: 'placeholder', value: __('admin/email.placeholders.title')},
		]
	});
	emailTitleDiv.appendChild(emailTitleInput);

	//email div
	let emailEmailDiv = mCreateElement({
		element: 'div',
	});
	emailAccordionBody.appendChild(emailEmailDiv);

	//email label
	let emailEmailLabel = mCreateElement({
		element: 'label',
		text: __('admin/email.fields.email'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `email-${emailId}`},
		],
	});
	emailEmailDiv.appendChild(emailEmailLabel);

	//email input
	let emailEmailInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `email-${emailId}`},
			{name: 'name', value: 'emails[email][]'},
			{name: 'placeholder', value: __('admin/email.placeholders.email')},
		]
	});
	emailEmailDiv.appendChild(emailEmailInput);

	//id
	let emailIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'emails[id][]'},
		]
	});
	emailElement.appendChild(emailIdInput);

	emailContainer.appendChild(emailElement);
}