import ClassicEditor from "./ckeditor";

window.addEventListener('DOMContentLoaded', function () {
	const editors = document.querySelectorAll('[data-toggle="ck-editor"]');

	for (const editor of editors) {
		ClassicEditor
			.create(editor, {
				// Editor configuration.
				toolbar: {
					shouldNotGroupWhenFull: true,
					sourceEditing: {
						allowCollaborationFeatures: true
					}
				},
				simpleUpload: {
					uploadUrl: route('admin.media.ckeditor'),
					withCredentials: true,
					headers: {
						'X-CSRF-TOKEN': csrfToken(),
					}
				}
			})
			.then(editor => {
			})
			.catch(error => {
				console.error(error.stack);
			});
	}
});
