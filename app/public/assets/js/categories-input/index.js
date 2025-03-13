$(function () {
	let preventChildChange = false;
	$('#category_item_id').on('change', function () {

		//disable all children
		for (let category of categories) {
			document.querySelector(`[data-child="category-${category.id}"]`).classList.add('d-none');
			const childSelect = document.getElementById(`children-${category.id}`);
			childSelect.selectedIndex = -1;
			preventChildChange = true;
			childSelect.dispatchEvent(new Event('change'));
		}

		const selectedCategory = categories.find(item => item.id === parseInt(this.value));
		document.querySelector(`[data-child="category-${selectedCategory.id}"]`).classList.remove('d-none');
	});

	document.querySelectorAll('[id^="children-"]').forEach(element => {
		$(element).on('change', function () {
			if (preventChildChange) {
				preventChildChange = false;
				return;
			}
			let parentCategoryId = document.getElementById('category_item_id').value;
			const selectedChildrenIds = $(this).val().map(childId => parseInt(childId));

			for (let category of categories) {
				for (let child of category.children) {
					if (!selectedChildrenIds.includes(child.id)) {
						document.querySelector(`[id="callPrice-${child.id}"]`).value = null;
						document.querySelector(`[id="chatPrice-${child.id}"]`).value = null;
						document.querySelector(`[data-price="${child.id}"]`).classList.add('d-none');
					}
				}
			}


			categories.find(category => category.id === parseInt(parentCategoryId))
				.children
				.filter(child => selectedChildrenIds.includes(child.id))
				.map(child => {
					document.querySelector(`[data-price="${child.id}"]`).classList.remove('d-none');
				});
		});
	});
});