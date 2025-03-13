"use strict";
$(function () {
	document.querySelector('[data-action="add-resume"]').addEventListener('click', function () {
		let resumes = document.getElementById('resumes');

		let lastResume = resumes.children.item(resumes.childElementCount - 1);
		let resumeId = parseInt(lastResume.getAttribute('data-resume')) + 1;

		//close other accordions
		for (let i = 1; i < resumeId; i++) {
			let mButton = document.querySelector(`[aria-controls="resume-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-resume="${i}"]`).classList.remove('active');
			document.getElementById(`resume-body-${i}`).classList.remove('show');
		}

		addResume(resumes, resumeId);
	});
});

function deleteResume(element) {
	let resumes = document.getElementById('resumes');

	let lastResume = resumes.children.item(resumes.childElementCount - 1);
	let lastResumeId = parseInt(lastResume.getAttribute('data-resume')) + 1;

	let resumeId = parseInt(element.parentElement.parentElement.getAttribute('data-resume'));

	if (resumeId + 1 < lastResumeId) {
		element.parentElement.parentElement.remove();

		for (let i = resumeId + 1; i < lastResumeId; i++) {
			let nextResume = resumes.querySelector(`[data-resume="${i}"]`);
			nextResume.setAttribute('data-resume', (i - 1).toString());

			nextResume.querySelector(`[id="resume-head-${i}"]`).setAttribute('id', `resume-head-${i - 1}`);

			let nextResumeBody = nextResume.querySelector(`[aria-controls="resume-body-${i}"]`);
			nextResumeBody.setAttribute('data-bs-target', `#resume-body-${i - 1}`);
			nextResumeBody.setAttribute('aria-controls', `resume-body-${i - 1}`);
			nextResumeBody.innerText = __('admin/resume.words.resume', {'num': i - 1});

			nextResume.querySelector(`[id="resume-body-${i}"]`).setAttribute('id', `resume-body-${i - 1}`);

			nextResume.querySelector(`[for="title-${i}"]`).setAttribute('for', `title-${i - 1}`);
			nextResume.querySelector(`[id="title-${i}"]`).setAttribute('id', `title-${i - 1}`);
		}
	} else {
		if (resumeId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addResume(resumeContainer, resumeId) {
	let resumeElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-resume', value: resumeId},
		]
	});

	//head
	let resumeHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `resume-head-${resumeId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	resumeElement.appendChild(resumeHeadElement);

	//delete button
	let resumeDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteResume(this)'},
		]
	});
	resumeHeadElement.appendChild(resumeDeleteButton);

	//delete icon
	let resumeDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	resumeDeleteButton.appendChild(resumeDeleteIcon);

	//accordion button
	let resumeAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/resume.words.resume', {'num': resumeId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#resume-body-${resumeId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `resume-body-${resumeId}`},
		],
	});
	resumeHeadElement.appendChild(resumeAccordionButton);

	//accordion collapse
	let resumeAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `resume-body-${resumeId}`},
		],
	});
	resumeElement.appendChild(resumeAccordionCollapse);

	//accordion body
	let resumeAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	resumeAccordionCollapse.appendChild(resumeAccordionBody);

	//title div
	let resumeTitleDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	resumeAccordionBody.appendChild(resumeTitleDiv);

	//title label
	let resumeTitleLabel = mCreateElement({
		element: 'label',
		text: __('admin/resume.fields.title'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `title-${resumeId}`},
		],
	});
	resumeTitleDiv.appendChild(resumeTitleLabel);

	//title input
	let resumeTitleInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `title-${resumeId}`},
			{name: 'name', value: 'resumes[title][]'},
			{name: 'placeholder', value: __('admin/resume.placeholders.title')},
		]
	});
	resumeTitleDiv.appendChild(resumeTitleInput);

	resumeContainer.appendChild(resumeElement);
}