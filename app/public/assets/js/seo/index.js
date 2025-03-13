"use strict";
$(function () {
	let seoTitleInput = document.getElementById('seo-title');
	let seoLinkInput = document.getElementById('seo-link');
	let seoableTitle = document.querySelector('[data-seo-title]');
	let seoableLink = document.querySelector('[data-seo-link]');
	let seoableTitleChild = document.querySelector('[data-seo-link-child]');
	let seoableLinkChild = document.querySelector('[data-seo-link-child]');

	if (seoLinkInput) {
		seoLinkInput.addEventListener('input', function () {
			this.value = toSeoUrl(this.value);
		});
	}

	let currentForm = document.getElementsByTagName('form');
	if (currentForm.length === 1) {
		currentForm.item(0).addEventListener('submit', function (e) {
			let seoTitle = '';
			if (seoableTitle) {
				seoTitle = seoableTitle.value;
			}

			if (seoableTitleChild) {
				seoTitle += ` ${seoableTitleChild.value}`;
			}

			if (!seoTitleInput.value) {
				seoTitleInput.value = seoTitle;
			}

			if (!seoLinkInput.value) {
				seoLinkInput.value = toSeoUrl(seoTitleInput.value);
			}
		});
	}

	// if (seoableTitle) {
	// 	seoableTitle.addEventListener('input', function () {
	// 		let seoTitle = this.value;
	// 		if (seoableTitleChild && seoableTitleChild.value) {
	// 			seoTitle += " " + seoableTitleChild.value;
	// 		}
	// 		seoTitleInput.value = seoTitle;
	// 	});
	// }

	// if (seoableLink) {
	// 	seoableLink.addEventListener('input', function () {
	// 		let seoLink = this.value;
	// 		if (seoableLinkChild && seoableLinkChild.value) {
	// 			seoLink += " " + seoableLinkChild.value;
	// 		}
	// 		seoLinkInput.value = toSeoUrl(seoLink);
	// 	});
	// }

	if (seoableTitleChild) {
		seoableTitleChild.addEventListener('input', function () {
			let seoTitle = this.value;
			if (seoableTitle && seoableTitle.value) {
				seoTitle = seoableTitle.value + " " + seoTitle;
			}
			seoTitleInput.value = seoTitle;
		});
	}

	if (seoableLinkChild) {
		seoableLinkChild.addEventListener('input', function () {
			let seoLink = this.value;
			if (seoableLink && seoableLink.value) {
				seoLink = seoableLink.value + " " + seoLink;
			}
			seoLinkInput.value = toSeoUrl(seoLink);
		});
	}
});