"use strict";

$(function () {

});

function addPath(element) {
	const allRoutes = document.getElementById('routes');

	const routeIndex = parseInt(allRoutes.children.item(allRoutes.childElementCount - 1).getAttribute('data-lines')) + 1;

	let divLines = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'col-md-6 mt-3'},
			{name: 'data-lines', value: routeIndex},
		]
	});
	allRoutes.appendChild(divLines);

	let routeHead = mCreateElement({
		element: 'h6',
		text: __('admin/communication.words.path.head', {num: routeIndex + 1})
	});
	divLines.appendChild(routeHead);

	let divAddLine = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'd-flex align-items-center'},
		]
	});
	divLines.appendChild(divAddLine);

	let lineHead = mCreateElement({
		element: 'h6',
		text: __('admin/communication.words.path.sub.plural'),
		attributes: [
			{name: 'class', value: 'm-0 flex-grow-1'},
		]
	});
	divAddLine.appendChild(lineHead);

	let btnAddLine = mCreateElement({
		element: 'button',
		html: '<span class="tf-icons bx bx-plus"></span>' + __('admin/communication.words.path.sub.add'),
		attributes: [
			{name: 'type', value: 'button'},
			{name: 'class', value: 'btn btn-primary'},
			{name: 'onclick', value: 'addSubPath(this)'},
			{name: 'data-index', value: routeIndex},
		]
	});
	divAddLine.appendChild(btnAddLine);

	let firstLine = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'name', value: `routes[${routeIndex}][lines][]`},
			{name: 'class', value: 'form-control mt-3'},
			{name: 'placeholder', value: __('admin/communication.placeholders.routes.path_line_text')},
		]
	});
	divLines.appendChild(firstLine);
}

function addSubPath(element) {
	const index = element.getAttribute('data-index');
	const lines = document.querySelector(`[data-lines="${index}"]`);

	const lineInput = mCreateElement({
		element: 'input',
		attributes: [
			{name: 'type', value: 'text'},
			{name: 'name', value: `routes[${index}][lines][]`},
			{name: 'class', value: 'form-control mt-3'},
			{name: 'placeholder', value: __('admin/communication.placeholders.routes.path_line_text')},
		]
	});

	lines.appendChild(lineInput);
}