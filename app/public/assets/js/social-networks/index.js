"use strict";
$(function () {
	document.querySelector('[data-action="add-socialNetwork"]').addEventListener('click', function () {
		let socialNetworks = document.getElementById('socialNetworks');

		let lastSocialNetwork = socialNetworks.children.item(socialNetworks.childElementCount - 1);
		let socialNetworkId = parseInt(lastSocialNetwork.getAttribute('data-socialNetwork')) + 1;

		//close other accordions
		for (let i = 1; i < socialNetworkId; i++) {
			let mButton = document.querySelector(`[aria-controls="socialNetwork-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-socialNetwork="${i}"]`).classList.remove('active');
			document.getElementById(`socialNetwork-body-${i}`).classList.remove('show');
		}

		addSocialNetwork(socialNetworks, socialNetworkId);
	});
});

function deleteSocialNetwork(element) {
	let socialNetworks = document.getElementById('socialNetworks');

	let lastSocialNetwork = socialNetworks.children.item(socialNetworks.childElementCount - 1);
	let lastSocialNetworkId = parseInt(lastSocialNetwork.getAttribute('data-socialNetwork')) + 1;
	let socialNetworkId = parseInt(element.parentElement.parentElement.getAttribute('data-socialNetwork'));

	if (socialNetworkId + 1 < lastSocialNetworkId) {
		element.parentElement.parentElement.remove();

		for (let i = socialNetworkId + 1; i < lastSocialNetworkId; i++) {
			let nextSocialNetwork = socialNetworks.querySelector(`[data-socialNetwork="${i}"]`);
			nextSocialNetwork.setAttribute('data-socialNetwork', (i - 1).toString());

			nextSocialNetwork.querySelector(`[id="socialNetwork-head-${i}"]`).setAttribute('id', `socialNetwork-head-${i - 1}`);

			let nextSocialNetworkBody = nextSocialNetwork.querySelector(`[aria-controls="socialNetwork-body-${i}"]`);
			nextSocialNetworkBody.setAttribute('data-bs-target', `#socialNetwork-body-${i - 1}`);
			nextSocialNetworkBody.setAttribute('aria-controls', `socialNetwork-body-${i - 1}`);
			nextSocialNetworkBody.innerText = __('admin/social_network.words.social_network', {'num': i - 1});

			nextSocialNetwork.querySelector(`[id="socialNetwork-body-${i}"]`).setAttribute('id', `socialNetwork-body-${i - 1}`);

			nextSocialNetwork.querySelector(`[for="typeId-${i}"]`).setAttribute('for', `typeId-${i - 1}`);
			nextSocialNetwork.querySelector(`[id="typeId-${i}"]`).setAttribute('id', `typeId-${i - 1}`);
			nextSocialNetwork.querySelector(`[data-select2-id="select2-data-typeId-${i}"]`).setAttribute('data-select2-id', `select2-data-typeId-${i - 1}`);
			nextSocialNetwork.querySelector(`[aria-labelledby="select2-typeId-${i}-container"]`).setAttribute('aria-labelledby', `select2-typeId-${i - 1}-container`);
			nextSocialNetwork.querySelector(`[aria-controls="select2-typeId-${i}-container"]`).setAttribute('aria-controls', `select2-typeId-${i - 1}-container`);
			nextSocialNetwork.querySelector(`[id="select2-typeId-${i}-container"]`).setAttribute('id', `select2-typeId-${i - 1}-container`);

			nextSocialNetwork.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextSocialNetwork.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextSocialNetwork.querySelector(`[for="address-${i}"]`).setAttribute('for', `address-${i - 1}`);
			nextSocialNetwork.querySelector(`[id="address-${i}"]`).setAttribute('id', `address-${i - 1}`);
		}
	} else {
		if (socialNetworkId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addSocialNetwork(socialNetworkContainer, socialNetworkId) {
	let socialNetworkElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-socialNetwork', value: socialNetworkId},
		]
	});

	//head
	let socialNetworkHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `socialNetwork-head-${socialNetworkId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	socialNetworkElement.appendChild(socialNetworkHeadElement);

	//delete button
	let socialNetworkDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteSocialNetwork(this)'},
		]
	});
	socialNetworkHeadElement.appendChild(socialNetworkDeleteButton);

	//delete icon
	let socialNetworkDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	socialNetworkDeleteButton.appendChild(socialNetworkDeleteIcon);

	//accordion button
	let socialNetworkAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/social_network.words.social_network', {'num': socialNetworkId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#socialNetwork-body-${socialNetworkId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `socialNetwork-body-${socialNetworkId}`},
		],
	});
	socialNetworkHeadElement.appendChild(socialNetworkAccordionButton);

	//accordion collapse
	let socialNetworkAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `socialNetwork-body-${socialNetworkId}`},
		],
	});
	socialNetworkElement.appendChild(socialNetworkAccordionCollapse);

	//accordion body
	let socialNetworkAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	socialNetworkAccordionCollapse.appendChild(socialNetworkAccordionBody);

	//type div
	let socialNetworkTypeDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	socialNetworkAccordionBody.appendChild(socialNetworkTypeDiv);

	//type label
	let socialNetworkTypeLabel = mCreateElement({
		element: 'label',
		text: __('admin/social_network.fields.type'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `typeId-${socialNetworkId}`},
		],
	});
	socialNetworkTypeDiv.appendChild(socialNetworkTypeLabel);

	//type input
	let socialNetworkTypeInput = mCreateElement({
		element: 'select',
		attributes: [
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `typeId-${socialNetworkId}`},
			{name: 'name', value: 'social_networks[type_id][]'},
			{name: 'data-placeholder', value: __('admin/global.words.choose')},
			{name: 'data-toggle', value: 'select2'},
		]
	});
	socialNetworkTypeDiv.appendChild(socialNetworkTypeInput);

	socialNetworkTypeInput.appendChild(mCreateElement({
		element: 'option'
	}));
	for (const socialNetworkType of socialNetworkTypes) {
		const typeOption = mCreateElement({
			element: 'option',
			text: socialNetworkType.name,
			attributes: [
				{name: 'value', value: socialNetworkType.id},
			]
		});
		socialNetworkTypeInput.appendChild(typeOption);
	}
	$(socialNetworkTypeInput).select2({
		theme: 'bootstrap-5',
		dir: 'rtl'
	});

	//title div
	let socialNetworkTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	socialNetworkAccordionBody.appendChild(socialNetworkTitleDiv);

	//title label
	let socialNetworkTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/social_network.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${socialNetworkId}`},
		],
	});
	socialNetworkTitleDiv.appendChild(socialNetworkTitleLabel);

	//title input
	let socialNetworkTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${socialNetworkId}`},
			{name: 'name', value: 'social_networks[title][]'},
			{name: 'placeholder', value: __('admin/social_network.placeholders.title')},
		]
	});
	socialNetworkTitleDiv.appendChild(socialNetworkTitleInput);

	//address div
	let socialNetworkAddressDiv = mCreateElement({
		element: 'div',
	});
	socialNetworkAccordionBody.appendChild(socialNetworkAddressDiv);

	//address label
	let socialNetworkValueLabel = mCreateElement({
		element: 'label',
		text: __('admin/social_network.fields.address'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `address-${socialNetworkId}`},
		],
	});
	socialNetworkAddressDiv.appendChild(socialNetworkValueLabel);

	//address input
	let socialNetworkAddressInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `address-${socialNetworkId}`},
			{name: 'name', value: 'social_networks[address][]'},
			{name: 'placeholder', value: __('admin/social_network.placeholders.address')},
		]
	});
	socialNetworkAddressDiv.appendChild(socialNetworkAddressInput);

	//id
	let socialNetworkIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'social_networks[id][]'},
		]
	});
	socialNetworkElement.appendChild(socialNetworkIdInput);

	socialNetworkContainer.appendChild(socialNetworkElement);
}