$(function () {
	let percentInput = document.getElementById('percent');
	let amountInput = document.getElementById('amount');

	percentInput.addEventListener('input', function () {
		let value = percentInput.value;

		if (!value) {
			amountInput.removeAttribute('readonly');
		} else {
			amountInput.setAttribute('readonly', true);
			amountInput.value = "";
		}
	});

	amountInput.addEventListener('input', function () {
		let value = amountInput.value;

		if (!value) {
			percentInput.removeAttribute('readonly');
		} else {
			percentInput.setAttribute('readonly', true);
			percentInput.value = "";
		}
	});

	let limitedUser = $('#is_limited');
	let usersElements = document.querySelector('[data-is-limited="user"]');

	limitedUser.on('select2:select', function () {
		switch (parseInt(limitedUser.val())) {
			case 0:
				usersElements.classList.add('d-none');
				break;

			case 1:
				usersElements.classList.remove('d-none');
				break;
		}
	});
});