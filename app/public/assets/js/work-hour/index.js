"use strict";
$(function () {
	document.querySelector('[data-action="add-work-hour"]').addEventListener('click', function () {
		let workHours = document.getElementById('work-hours');

		let lastWorkHour = workHours.children.item(workHours.childElementCount - 1);
		let workHourId = parseInt(lastWorkHour.getAttribute('data-work-hour')) + 1;

		//close other accordions
		for (let i = 1; i < workHourId; i++) {
			let mButton = document.querySelector(`[aria-controls="work-hour-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-work-hour="${i}"]`).classList.remove('active');
			document.getElementById(`work-hour-body-${i}`).classList.remove('show');
		}

		addWorkHour(workHours, workHourId);
	});
});

function deleteWorkHour(element) {
	let workHours = document.getElementById('work-hours');

	let lastWorkHour = workHours.children.item(workHours.childElementCount - 1);
	let lastWorkHourId = parseInt(lastWorkHour.getAttribute('data-work-hour')) + 1;


	let workHourId = parseInt(element.parentElement.parentElement.getAttribute('data-work-hour'));

	if (workHourId + 1 < lastWorkHourId) {
		element.parentElement.parentElement.remove();

		for (let i = workHourId + 1; i < lastWorkHourId; i++) {
			let nextWorkHour = workHours.querySelector(`[data-work-hour="${i}"]`);
			nextWorkHour.setAttribute('data-work-hour', (i - 1).toString());

			nextWorkHour.querySelector(`[id="work-hour-head-${i}"]`).setAttribute('id', `work-hour-head-${i - 1}`);

			let nextWorkHourBody = nextWorkHour.querySelector(`[aria-controls="work-hour-body-${i}"]`);
			nextWorkHourBody.setAttribute('data-bs-target', `#work-hour-body-${i - 1}`);
			nextWorkHourBody.setAttribute('aria-controls', `work-hour-body-${i - 1}`);
			nextWorkHourBody.innerText = __('admin/work_hour.words.title', {'num': i - 1});

			nextWorkHour.querySelector(`[id="work-hour-body-${i}"]`).setAttribute('id', `work-hour-body-${i - 1}`);

			nextWorkHour.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextWorkHour.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);

			nextWorkHour.querySelector(`[id="first-from-hour-${i}"]`).setAttribute('id', `first-from-hour-${i - 1}`);
			nextWorkHour.querySelector(`[id="first-to-hour-${i}"]`).setAttribute('id', `first-to-hour-${i - 1}`);

			nextWorkHour.querySelector(`[id="second-from-hour-${i}"]`).setAttribute('id', `second-from-hour-${i - 1}`);
			nextWorkHour.querySelector(`[id="second-to-hour-${i}"]`).setAttribute('id', `second-to-hour-${i - 1}`);
		}
	} else {
		if (workHourId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addWorkHour(workHourContainer, workHourId) {
	let workHourElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-work-hour', value: workHourId},
		]
	});

	//head
	let workHourHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `work-hour-head-${workHourId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	workHourElement.appendChild(workHourHeadElement);

	//delete button
	let workHourDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteWorkHour(this)'},
		]
	});
	workHourHeadElement.appendChild(workHourDeleteButton);

	//delete icon
	let workHourDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	workHourDeleteButton.appendChild(workHourDeleteIcon);

	//accordion button
	let workHourAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/work_hour.words.title', {'num': workHourId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#work-hour-body-${workHourId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `work-hour-body-${workHourId}`},
		],
	});
	workHourHeadElement.appendChild(workHourAccordionButton);

	//accordion collapse
	let workHourAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `work-hour-body-${workHourId}`},
		],
	});
	workHourElement.appendChild(workHourAccordionCollapse);

	//accordion body
	let workHourAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	workHourAccordionCollapse.appendChild(workHourAccordionBody);

	//title div
	let workHourTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	workHourAccordionBody.appendChild(workHourTitleDiv);

	//title label
	let workHourTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/work_hour.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${workHourId}`},
		],
	});
	workHourTitleDiv.appendChild(workHourTitleLabel);

	//title input
	let workHourTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${workHourId}`},
			{name: 'name', value: 'work_hours[title][]'},
			{name: 'placeholder', value: __('admin/work_hour.placeholders.title')},
		]
	});
	workHourTitleDiv.appendChild(workHourTitleInput);

	//time separator
	let workHourTimeFirstSeparatorSpan = mCreateElement({
		element: 'span',
		text: __('admin/global.words.until'),
		attributes: [
			{name: 'class', value: 'input-group-text'},
		],
	});
	let workHourTimeSecondSeparatorSpan = mCreateElement({
		element: 'span',
		text: __('admin/global.words.until'),
		attributes: [
			{name: 'class', value: 'input-group-text'},
		],
	});

	//first time div
	let workHourTimeFirstDiv = mCreateElement({
		element: 'div'
	});
	workHourAccordionBody.appendChild(workHourTimeFirstDiv);

	//first time label
	let workHourTimeFirstLabel = mCreateElement({
		element: 'label',
		text: __('admin/work_hour.words.shift.first'),
		attributes: [
			{name: 'class', value: 'form-label'}
		]
	});
	workHourTimeFirstDiv.appendChild(workHourTimeFirstLabel);

	//first time div group
	let workHourTimeFirstGroupDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'input-group'}
		]
	});
	workHourTimeFirstDiv.appendChild(workHourTimeFirstGroupDiv);

	//first from time picker
	let workHourFirstFromInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'id', value: `first-from-hour-${workHourId}`},
			{name: 'name', value: 'work_hours[first][from][]'},
			{name: 'class', value: 'form-control'},
			{name: 'placeholder', value: __('admin/global.placeholders.time')},
			{name: 'data-jdp', value: ''},
			{name: 'data-jdp-only-time', value: ''},
			{name: 'readonly', value: ''},
		],
	});
	workHourTimeFirstGroupDiv.appendChild(workHourFirstFromInput);

	//first time separator
	workHourTimeFirstGroupDiv.appendChild(workHourTimeFirstSeparatorSpan);

	//first to time
	let workHourFirstToInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'id', value: `first-to-hour-${workHourId}`},
			{name: 'name', value: 'work_hours[first][to][]'},
			{name: 'class', value: 'form-control'},
			{name: 'placeholder', value: __('admin/global.placeholders.time')},
			{name: 'data-jdp', value: ''},
			{name: 'data-jdp-only-time', value: ''},
			{name: 'readonly', value: ''},
		],
	});
	workHourTimeFirstGroupDiv.appendChild(workHourFirstToInput);

	//second time div
	let workHourTimeSecondDiv = mCreateElement({
		element: 'div'
	});
	workHourAccordionBody.appendChild(workHourTimeSecondDiv);

	//second time label
	let workHourTimeSecondLabel = mCreateElement({
		element: 'label',
		text: __('admin/work_hour.words.shift.second'),
		attributes: [
			{name: 'class', value: 'form-label'}
		]
	});
	workHourTimeSecondDiv.appendChild(workHourTimeSecondLabel);

	//second time div group
	let workHourTimeSecondGroupDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'input-group'}
		]
	});
	workHourTimeSecondDiv.appendChild(workHourTimeSecondGroupDiv);

	//second from time picker
	let workHourSecondFromInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'id', value: `second-from-hour-${workHourId}`},
			{name: 'name', value: 'work_hours[second][from][]'},
			{name: 'class', value: 'form-control'},
			{name: 'placeholder', value: __('admin/global.placeholders.time')},
			{name: 'data-jdp', value: ''},
			{name: 'data-jdp-only-time', value: ''},
			{name: 'readonly', value: ''},
		],
	});
	workHourTimeSecondGroupDiv.appendChild(workHourSecondFromInput);

	//second time separator
	workHourTimeSecondGroupDiv.appendChild(workHourTimeSecondSeparatorSpan);

	//second to time
	let workHourSecondToInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'id', value: `second-to-hour-${workHourId}`},
			{name: 'name', value: 'work_hours[second][to][]'},
			{name: 'class', value: 'form-control'},
			{name: 'placeholder', value: __('admin/global.placeholders.time')},
			{name: 'data-jdp', value: ''},
			{name: 'data-jdp-only-time', value: ''},
			{name: 'readonly', value: ''},
		],
	});
	workHourTimeSecondGroupDiv.appendChild(workHourSecondToInput);

	workHourContainer.appendChild(workHourElement);
}