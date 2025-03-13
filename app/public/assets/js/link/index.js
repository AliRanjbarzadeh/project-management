"use strict";
$(function () {
	document.querySelector('[data-action="add-link"]').addEventListener('click', function () {
		let links = document.getElementById('links');

		let lastLink = links.children.item(links.childElementCount - 1);
		let linkId = parseInt(lastLink.getAttribute('data-link')) + 1;

		//close other accordions
		for (let i = 1; i < linkId; i++) {
			let mButton = document.querySelector(`[aria-controls="link-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-link="${i}"]`).classList.remove('active');
			document.getElementById(`link-body-${i}`).classList.remove('show');
		}

		addLink(links, linkId);
	});
});

function deleteLink(element) {
	let links = document.getElementById('links');

	let lastLink = links.children.item(links.childElementCount - 1);
	let lastLinkId = parseInt(lastLink.getAttribute('data-link')) + 1;

	let linkId = parseInt(element.parentElement.parentElement.getAttribute('data-link'));

	if (linkId + 1 < lastLinkId) {
		element.parentElement.parentElement.remove();

		for (let i = linkId + 1; i < lastLinkId; i++) {
			let nextLink = links.querySelector(`[data-link="${i}"]`);
			nextLink.setAttribute('data-link', (i - 1).toString());

			nextLink.querySelector(`[id="link-head-${i}"]`).setAttribute('id', `link-head-${i - 1}`);

			let nextLinkBody = nextLink.querySelector(`[aria-controls="link-body-${i}"]`);
			nextLinkBody.setAttribute('data-bs-target', `#link-body-${i - 1}`);
			nextLinkBody.setAttribute('aria-controls', `link-body-${i - 1}`);
			nextLinkBody.innerText = __('admin/link.words.link', {'num': i - 1});

			nextLink.querySelector(`[id="link-body-${i}"]`).setAttribute('id', `link-body-${i - 1}`);

			nextLink.querySelector(`[for="link-${i}"]`).setAttribute('for', `link-${i - 1}`);
			nextLink.querySelector(`[id="link-${i}"]`).setAttribute('id', `link-${i - 1}`);
		}
	} else {
		if (linkId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addLink(linkContainer, linkId) {
	let linkElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-link', value: linkId},
		]
	});

	//head
	let linkHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `link-head-${linkId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	linkElement.appendChild(linkHeadElement);

	//delete button
	let linkDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteLink(this)'},
		]
	});
	linkHeadElement.appendChild(linkDeleteButton);

	//delete icon
	let linkDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	linkDeleteButton.appendChild(linkDeleteIcon);

	//accordion button
	let linkAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/link.words.link', {'num': linkId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#link-body-${linkId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `link-body-${linkId}`},
		],
	});
	linkHeadElement.appendChild(linkAccordionButton);

	//accordion collapse
	let linkAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `link-body-${linkId}`},
		],
	});
	linkElement.appendChild(linkAccordionCollapse);

	//accordion body
	let linkAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	linkAccordionCollapse.appendChild(linkAccordionBody);

	//link div
	let linkLinkDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	linkAccordionBody.appendChild(linkLinkDiv);

	//title label
	let linkTitleLable = mCreateElement({
		element: 'label',
		text: __('admin/link.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${linkId}`},
		],
	});
	linkLinkDiv.appendChild(linkTitleLable);

	//title input
	let linkTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${linkId}`},
			{name: 'name', value: 'links[title][]'},
			{name: 'placeholder', value: __('admin/link.placeholders.title')},
		]
	});
	linkLinkDiv.appendChild(linkTitleInput);

	//link label
	let linkLinkLabel = mCreateElement({
		element: 'label',
		text: __('admin/link.fields.link'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `link-${linkId}`},
		],
	});
	linkLinkDiv.appendChild(linkLinkLabel);

	//link input
	let linkLinkInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `link-${linkId}`},
			{name: 'name', value: 'links[url][]'},
			{name: 'placeholder', value: __('admin/link.placeholders.link')},
		]
	});
	linkLinkDiv.appendChild(linkLinkInput);

	linkContainer.appendChild(linkElement);
}