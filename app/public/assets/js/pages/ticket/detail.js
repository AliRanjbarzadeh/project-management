$(function () {
	const messages = document.getElementById('messages');
	const messagesScroll = new PerfectScrollbar(messages, {
		wheelPropagation: true,
	});

	messages.scrollTop = messages.scrollHeight;
});