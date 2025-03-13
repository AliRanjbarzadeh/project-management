"use strict";
$(function () {
	document.querySelector('[data-action="add-sign"]').addEventListener('click', function () {
		let signs = document.getElementById('signs');

		let lastSign = signs.children.item(signs.childElementCount - 1);
		let signId = parseInt(lastSign.getAttribute('data-sign')) + 1;

		//close other accordions
		for (let i = 1; i < signId; i++) {
			let mButton = document.querySelector(`[aria-controls="sign-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-sign="${i}"]`).classList.remove('active');
			document.getElementById(`sign-body-${i}`).classList.remove('show');
		}

		addSign(signs, signId);
	});
});

function deleteSign(element) {
	let signs = document.getElementById('signs');

	let lastSign = signs.children.item(signs.childElementCount - 1);
	let lastSignId = parseInt(lastSign.getAttribute('data-sign')) + 1;


	let signId = parseInt(element.parentElement.parentElement.getAttribute('data-sign'));

	if (signId + 1 < lastSignId) {
		element.parentElement.parentElement.remove();

		for (let i = signId + 1; i < lastSignId; i++) {
			let nextSign = signs.querySelector(`[data-sign="${i}"]`);
			nextSign.setAttribute('data-sign', (i - 1).toString());

			nextSign.querySelector(`[id="sign-head-${i}"]`).setAttribute('id', `sign-head-${i - 1}`);

			let nextSignBody = nextSign.querySelector(`[aria-controls="sign-body-${i}"]`);
			nextSignBody.setAttribute('data-bs-target', `#sign-body-${i - 1}`);
			nextSignBody.setAttribute('aria-controls', `sign-body-${i - 1}`);
			nextSignBody.innerText = __('admin/sign.words.title', {'num': i - 1});

			nextSign.querySelector(`[id="sign-body-${i}"]`).setAttribute('id', `sign-body-${i - 1}`);

			nextSign.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextSign.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextSign.querySelector(`[for="content-${i}"]`).setAttribute('for', `content-${i - 1}`);
			nextSign.querySelector(`[id="content-${i}"]`).setAttribute('id', `content-${i - 1}`);
		}
	} else {
		if (signId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addSign(signContainer, signId) {
	let signElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-sign', value: signId},
		]
	});

	//head
	let signHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `sign-head-${signId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	signElement.appendChild(signHeadElement);

	//delete button
	let signDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteSign(this)'},
		]
	});
	// signDeleteButton.addEventListener('click', deleteSign(signDeleteButton));
	signHeadElement.appendChild(signDeleteButton);

	//delete icon
	let signDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	signDeleteButton.appendChild(signDeleteIcon);

	//accordion button
	let signAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/sign.words.title', {'num': signId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#sign-body-${signId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `sign-body-${signId}`},
		],
	});
	signHeadElement.appendChild(signAccordionButton);

	//accordion collapse
	let signAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `sign-body-${signId}`},
		],
	});
	signElement.appendChild(signAccordionCollapse);

	//accordion body
	let signAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	signAccordionCollapse.appendChild(signAccordionBody);

	//title div
	let signTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	signAccordionBody.appendChild(signTitleDiv);

	//title label
	let signTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/sign.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${signId}`},
		],
	});
	signTitleDiv.appendChild(signTitleLabel);

	//title input
	let signTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${signId}`},
			{name: 'name', value: 'signs[title][]'},
			{name: 'placeholder', value: __('admin/sign.placeholders.title')},
		]
	});
	signTitleDiv.appendChild(signTitleInput);

	//content div
	let signContentDiv = mCreateElement({
		element: 'div',
	});
	signAccordionBody.appendChild(signContentDiv);

	//content label
	let signContentLabel = mCreateElement({
		element: 'label',
		text: __('admin/sign.fields.content'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `content-${signId}`},
		],
	});
	signContentDiv.appendChild(signContentLabel);

	//content input
	let signContentInput = mCreateElement({
		element: 'textarea',
		attributes: [
			{name: 'rows', value: 4},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `content-${signId}`},
			{name: 'name', value: 'signs[content][]'},
			{name: 'placeholder', value: __('admin/sign.placeholders.content')},
		]
	});
	signContentDiv.appendChild(signContentInput);

	//id
	let signIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'signs[id][]'},
		]
	});
	signElement.appendChild(signIdInput);

	signContainer.appendChild(signElement);
}