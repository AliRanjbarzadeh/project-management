$(function () {
	$('#category_item_id').on('change', function () {
		const categoryItemId = this.value;

		let category = consultant.categories.find(item => item.id === parseInt(categoryItemId));
		document.getElementById('percent').value = category.percent;

		let categoryPrice = consultant.categories_prices.find(item => item.category_item_id === parseInt(categoryItemId));

		const callPriceExtra = __('admin/plan.sentences.suggested_price', {price: `${number_format(categoryPrice.price_extra)} ${__('admin/global.words.price.unit')}`});
		const callPrice = __('admin/plan.sentences.suggested_price', {price: `${number_format(categoryPrice.price)} ${__('admin/global.words.price.unit')}`});
		const chatPrice = __('admin/plan.sentences.suggested_price', {price: `${number_format(categoryPrice.chat_price)} ${__('admin/global.words.price.unit')}`});

		document.getElementById('priceExtraCall').value = number_format(categoryPrice.price_extra);
		document.getElementById('priceExtra-call').innerText = callPriceExtra;
		document.getElementById('price-call').innerText = callPrice;
		document.getElementById('price-chat').innerText = chatPrice;
	});
});