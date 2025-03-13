"use strict";

let images = [], imagesInput;
$(function () {
	imagesInput = document.querySelector('[name="images"]');

	new Dropzone('div#gallery', {
		init: function () {
			const mDropzone = this;
			mDropzone.on('success', dropzoneFileSuccessUpload);
			mDropzone.on('removedfile', dropzoneFileRemoved);

			if (uploadedFiles.length > 0) {
				for (const uploadedFile of uploadedFiles) {
					const mockFile = {
						name: uploadedFile.real_name,
						size: uploadedFile.size,
						type: uploadedFile.mime_type,
						accepted: true,
						xhr: {
							response: JSON.stringify({
								id: uploadedFile.id,
								name: uploadedFile.pivot.name,
							})
						},
						model: {
							id: uploadedFile.pivot.model_id,
							type: uploadedFile.pivot.model_type,
						}
					};
					mDropzone.files.push(mockFile);
					mDropzone.emit('addedfile', mockFile);
					mDropzone.emit('thumbnail', mockFile, uploadedFile.sizes.thumbnail);
					mDropzone.emit('success', mockFile);
					mDropzone.emit('complete', mockFile);
				}
			}
		},
		url: route('admin.media.dropzone'),
		previewTemplate: document.getElementById('dzPreview').innerHTML,
		acceptedFiles: 'image/png,image/jpg,image/jpeg,image/JPG,image/JPEG',
		headers: {
			'X-CSRF-TOKEN': csrfToken()
		},
	});
});

function dropzoneFileSuccessUpload(file) {
	const medium = JSON.parse(file.xhr.response);
	images.push({mediumId: medium.id, name: 'gallery'});
	imagesInput.value = JSON.stringify(images);
}

function dropzoneFileRemoved(file) {
	if (file.xhr.response) {
		const medium = JSON.parse(file.xhr.response);
		let removedIndex = images.findIndex(item => item.mediumId === medium.id);
		if (removedIndex >= 0) {
			images.splice(removedIndex, 1);
		} else {
			return;
		}
		imagesInput.value = JSON.stringify(images);

		if (!file.model) {
			axios.delete(route('admin.media.destroy', {id: medium.id}), {
				data: {
					model: file.model ?? null
				}
			}).then(response => {
			}).catch(error => {
				console.error(error);
			});
		}
	}
}