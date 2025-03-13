"use strict";

$(function () {
	$('[data-show-type]').on('change', function (e) {
		let type = this.getAttribute('data-type');

		let itemsToShowInput = document.getElementById(`${type}_items_to_show`);
		switch (this.value) {
			case 'all':
				itemsToShowInput.setAttribute('readonly', 'readonly');
				itemsToShowInput.value = 0;
				break;

			case 'some':
				itemsToShowInput.removeAttribute('readonly');
				itemsToShowInput.value = itemsToShowInput.getAttribute('min');
				break;
		}
	});
});
