"use strict";

let topItems = [];
$(function () {
	const topItemsSelect = $('#top_items');
	const topItemsInput = document.getElementById('top_items_input');
	if (topItemsInput.value) {
		topItems = JSON.parse(topItemsInput.value);
	}
	topItemsSelect.select2({
		theme: 'bootstrap-5',
		dropdownCssClass: 'top-blogs',
		multiple: true,
		ajax: {
			method: 'POST',
			delay: 250,
			dataType: 'json',
			url: route('admin.blogs.search'),
			data: function (params) {
				return {
					ids: topItemsSelect.val(),
					term: params.term
				};
			},
			processResults: (data) => {
				return {
					results: data.map((blog) => {
						return {
							id: blog.id,
							text: blog.title,
							item: blog
						};
					})
				};
			}
		},
		minimumInputLength: 1,
		templateResult: formatBlogResult,
		templateSelection: formatBlogSelection
	}).on('select2:select', function (e) {
		let item = e.params.data;
		topItems.push({id: parseInt(item.id), title: item.text});
		updateTopItems();
	}).on('select2:unselect', function (e) {
		let item = e.params.data;
		topItems.splice(topItems.find(mItem => parseInt(mItem.id) === parseInt(item.id)), 1);
		updateTopItems();
	});
});

function formatBlogResult(response) {
	if (response.loading) {
		return response.text;
	}
	const blog = response.item;
	return $(getBlogTemplate(blog));
}

function formatBlogSelection(blog) {
	return blog.text;
}

function updateTopItems() {
	let topItemsInput = document.getElementById('top_items_input');
	topItemsInput.value = JSON.stringify(topItems.map((item) => {
		return {id: item.id, title: item.title};
	}));
}

function getBlogTemplate(blog) {
	let imagePath = blog.media[0].url;
	if (blog.media[0].sizes != null) {
		imagePath = blog.media[0].sizes.thumbnail;
	}

	let cardDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card rounded-0'}
		]
	});

	let cardRow = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'row g-0 align-items-center'}
		]
	});
	cardDiv.appendChild(cardRow);

	let cardDivCol4 = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'col-auto'}
		]
	});
	cardRow.appendChild(cardDivCol4);

	let cardImage = mCreateElement({
		element: 'img',
		attributes: [
			{name: 'class', value: 'img-thumbnail ms-4 w-px-75 rounded-circle'},
			{name: 'src', value: imagePath},
		]
	});
	cardDivCol4.appendChild(cardImage);

	let cardDivCol8 = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'col-auto flex-grow-1'}
		]
	});
	cardRow.appendChild(cardDivCol8);

	let cardBodyDiv = mCreateElement({
		element: 'div',
		attributes: [
			{name: 'class', value: 'card-body'}
		]
	});
	cardDivCol8.appendChild(cardBodyDiv);

	let cardTitle = mCreateElement({
		element: 'h5',
		text: blog.title,
		attributes: [
			{name: 'class', value: 'card-title'}
		]
	});
	cardBodyDiv.appendChild(cardTitle);

	return cardDiv;
}
