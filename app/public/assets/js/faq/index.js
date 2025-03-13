"use strict";
$(function () {
	document.querySelector('[data-action="add-faq"]').addEventListener('click', function () {
		let faqs = document.getElementById('faqs');

		let lastFaq = faqs.children.item(faqs.childElementCount - 1);
		let faqId = parseInt(lastFaq.getAttribute('data-faq')) + 1;

		//close other accordions
		for (let i = 1; i < faqId; i++) {
			let mButton = document.querySelector(`[aria-controls="faq-body-${i}"]`);
			mButton.classList.add('collapsed');
			mButton.setAttribute('aria-expanded', 'false');

			document.querySelector(`[data-faq="${i}"]`).classList.remove('active');
			document.getElementById(`faq-body-${i}`).classList.remove('show');
		}

		addFaq(faqs, faqId);
	});
});

function deleteFaq(element) {
	let faqs = document.getElementById('faqs');

	let lastFaq = faqs.children.item(faqs.childElementCount - 1);
	let lastFaqId = parseInt(lastFaq.getAttribute('data-faq')) + 1;


	let faqId = parseInt(element.parentElement.parentElement.getAttribute('data-faq'));

	if (faqId + 1 < lastFaqId) {
		element.parentElement.parentElement.remove();

		for (let i = faqId + 1; i < lastFaqId; i++) {
			let nextFaq = faqs.querySelector(`[data-faq="${i}"]`);
			nextFaq.setAttribute('data-faq', (i - 1).toString());

			nextFaq.querySelector(`[id="faq-head-${i}"]`).setAttribute('id', `faq-head-${i - 1}`);

			let nextFaqBody = nextFaq.querySelector(`[aria-controls="faq-body-${i}"]`);
			nextFaqBody.setAttribute('data-bs-target', `#faq-body-${i - 1}`);
			nextFaqBody.setAttribute('aria-controls', `faq-body-${i - 1}`);
			nextFaqBody.innerText = __('admin/faq.words.question', {'num': i - 1});

			nextFaq.querySelector(`[id="faq-body-${i}"]`).setAttribute('id', `faq-body-${i - 1}`);

			nextFaq.querySelector(`[for="question-${i}"]`).setAttribute('for', `question-${i - 1}`);
			nextFaq.querySelector(`[id="question-${i}"]`).setAttribute('id', `question-${i - 1}`);

			nextFaq.querySelector(`[for="answer-${i}"]`).setAttribute('for', `answer-${i - 1}`);
			nextFaq.querySelector(`[id="answer-${i}"]`).setAttribute('id', `answer-${i - 1}`);
		}
	} else {
		if (faqId > 1) {
			element.parentElement.parentElement.remove();
		}
	}
}

function addFaq(faqContainer, faqId) {
	let faqElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card accordion-item active'},
			{name: 'data-faq', value: faqId},
		]
	});

	//head
	let faqHeadElement = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'id', value: `faq-head-${faqId}`},
			{name: 'class', value: 'accordion-header d-flex align-items-center'},
		]
	});
	faqElement.appendChild(faqHeadElement);

	//delete button
	let faqDeleteButton = mCreateElement({
		element: 'button',
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-icon btn-outline-danger btn-sm rounded-pill ms-3'},
			{name: 'onclick', value: 'deleteFaq(this)'},
		]
	});
	// faqDeleteButton.addEventListener('click', deleteFaq(faqDeleteButton));
	faqHeadElement.appendChild(faqDeleteButton);

	//delete icon
	let faqDeleteIcon = mCreateElement({
		element: 'span',
		attributes: [
			{name: 'class', value: 'tf-icons bx bx-x'},
		]
	});
	faqDeleteButton.appendChild(faqDeleteIcon);

	//accordion button
	let faqAccordionButton = mCreateElement({
		element: 'button',
		text: __('admin/faq.words.question', {'num': faqId}),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'accordion-button'},
			{name: 'data-bs-toggle', value: 'collapse'},
			{name: 'data-bs-target', value: `#faq-body-${faqId}`},
			{name: 'aria-expanded', value: 'true'},
			{name: 'aria-controls', value: `faq-body-${faqId}`},
		],
	});
	faqHeadElement.appendChild(faqAccordionButton);

	//accordion collapse
	let faqAccordionCollapse = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-collapse collapse show'},
			{name: 'id', value: `faq-body-${faqId}`},
		],
	});
	faqElement.appendChild(faqAccordionCollapse);

	//accordion body
	let faqAccordionBody = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'accordion-body'},
		],
	});
	faqAccordionCollapse.appendChild(faqAccordionBody);

	//question div
	let faqQuestionDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'mb-3'},
		],
	});
	faqAccordionBody.appendChild(faqQuestionDiv);

	//question label
	let faqQuestionLabel = mCreateElement({
		element: 'label',
		text: __('admin/faq.fields.question'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `question-${faqId}`},
		],
	});
	faqQuestionDiv.appendChild(faqQuestionLabel);

	//question input
	let faqQuestionInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `question-${faqId}`},
			{name: 'name', value: 'faqs[question][]'},
			{name: 'placeholder', value: __('admin/faq.placeholders.question')},
		]
	});
	faqQuestionDiv.appendChild(faqQuestionInput);

	//answer div
	let faqAnswerDiv = mCreateElement({
		element: 'div',
	});
	faqAccordionBody.appendChild(faqAnswerDiv);

	//answer label
	let faqAnswerLabel = mCreateElement({
		element: 'label',
		text: __('admin/faq.fields.answer'),
		attributes: [
			{name: 'class', value: 'form-label'},
			{name: 'for', value: `answer-${faqId}`},
		],
	});
	faqAnswerDiv.appendChild(faqAnswerLabel);

	//answer input
	let faqAnswerInput = mCreateElement({
		element: 'textarea',
		attributes: [
			{name: 'rows', value: 4},
			{name: 'class', value: 'form-control'},
			{name: 'id', value: `answer-${faqId}`},
			{name: 'name', value: 'faqs[answer][]'},
			{name: 'placeholder', value: __('admin/faq.placeholders.answer')},
		]
	});
	faqAnswerDiv.appendChild(faqAnswerInput);

	//id
	let faqIdInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'hidden'},
			{name: 'value', value: 'id-0'},
			{name: 'name', value: 'faqs[id][]'},
		]
	});
	faqElement.appendChild(faqIdInput);

	faqContainer.appendChild(faqElement);
}