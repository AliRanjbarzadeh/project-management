window.addEventListener('DOMContentLoaded', function () {
	const editors = document.querySelectorAll('[data-toggle="ck-editor"]');

	for (const editor of editors) {
		CKEDITOR.replace(editor.id);
	}
});
