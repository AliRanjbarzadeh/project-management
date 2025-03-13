window.addEventListener('DOMContentLoaded', function () {
	const editors = document.querySelectorAll('[data-toggle="ck-editor"]');

	for (const editor of editors) {
		CKEDITOR.replace(editor.id, {
			filebrowserBrowseUrl: route('admin.fileManager.index'),
			// filebrowserImageBrowseUrl: base_url + 'vendor/fileman/index.html?type=image&langCode=fa',
			removeDialogTabs: 'link:upload;image:upload'
		});
	}
});
