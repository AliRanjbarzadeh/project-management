"use strict";

let menu, animate;
!function () {
	let e = document.querySelectorAll("#layout-menu"),
		t = (e.forEach(function (e) {
			menu = new Menu(e, {orientation: "vertical", closeChildren: !1}), window.Helpers.scrollToActive(animate = !1), window.Helpers.mainMenu = menu
		}), document.querySelectorAll(".layout-menu-toggle"));
	t.forEach(e => {
		e.addEventListener("click", e => {
			e.preventDefault(), window.Helpers.toggleCollapsed()
		})
	});
	if (document.getElementById("layout-menu")) {
		var l = document.getElementById("layout-menu");
		var o = function () {
			Helpers.isSmallScreen() || document.querySelector(".layout-menu-toggle").classList.add("d-block")
		};
		let e = null;
		l.onmouseenter = function () {
			e = Helpers.isSmallScreen() ? setTimeout(o, 0) : setTimeout(o, 300)
		}, l.onmouseleave = function () {
			document.querySelector(".layout-menu-toggle").classList.remove("d-block"), clearTimeout(e)
		}
	}
	let n = document.getElementsByClassName("menu-inner"),
		s = document.getElementsByClassName("menu-inner-shadow")[0];
	0 < n.length && s && n[0].addEventListener("ps-scroll-y", function () {
		this.querySelector(".ps__thumb-y").offsetTop ? s.style.display = "block" : s.style.display = "none"
	});

	function c(e) {
		"show.bs.collapse" == e.type || "show.bs.collapse" == e.type ? e.target.closest(".accordion-item").classList.add("active") : e.target.closest(".accordion-item").classList.remove("active")
	}

	const i = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')),
		a = (i.map(function (e) {
			return new bootstrap.Tooltip(e)
		}), [].slice.call(document.querySelectorAll(".accordion")));
	a.map(function (e) {
		e.addEventListener("show.bs.collapse", c), e.addEventListener("hide.bs.collapse", c)
	});
	window.Helpers.setAutoUpdate(!0), window.Helpers.initPasswordToggle(), window.Helpers.initSpeechToText(), window.Helpers.isSmallScreen() || window.Helpers.setCollapsed(!0, !1);

	handleInputs();
}();

/**
 *
 * @param options
 * @returns {HTMLElement, Element}
 */
function mCreateElement(options) {
	let element = document.createElement(options.element);

	if (options.attributes) {
		for (const attribute of options.attributes) {
			element.setAttribute(attribute.name, attribute.value);
			// if (attribute.value) {
			// } else {
			// 	element.setAttribute(attribute.name);
			// }
		}
	}

	if (options.text) {
		element.innerText = options.text;
	}

	if (options.html) {
		element.innerHTML = options.html;
	}

	return element;
}

function nl2br(str, is_xhtml) {
	if (typeof str === 'undefined' || str === null) {
		return '';
	}
	var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
	return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}

function toSeoUrl(url) {
	if (!url) {
		return url;
	}

	const words = url.split('-').join(' ')
		.replace(/[!-\/:-@[-`{-~]/g, "") //remove special characters
		.replace(/÷+/g, "")
		.replace(/٬+/g, "")
		.replace(/٫+/g, "")
		.replace(/٪+/g, "")
		.replace(/×+/g, "")
		.replace(/،+/g, "")
		.replace(/ـ+/g, "")
		.replace(/؟+/g, "")
		.replace(/\s+/g, " ")
		.split(' ');
	const newWords = [];
	for (let word of words) {
		if (word.length > 0) {
			newWords.push(word);
		} else {
			newWords.push('');
			break;
		}
	}

	return newWords.join('-');
}

// noinspection DuplicatedCode
function number_format(a, b, c, d) {
	if (!a && a !== 0) {
		return '';
	}
	a = (a + "").replace(/[^0-9+\-Ee.]/g, "");
	var e = isFinite(+a) ? +a : 0,
		f = isFinite(+b) ? Math.abs(b) : 0,
		g = void 0 === d ? "," : d,
		h = void 0 === c ? "." : c,
		i = "";
	return i = (f ? function (a, b) {
		var c = Math.pow(10, b);
		return "" + (Math.round(a * c) / c).toFixed(b)
	}(e, f) : "" + Math.round(e)).split("."), i[0].length > 3 && (i[0] = i[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, g)), (i[1] || "").length < f && (i[1] = i[1] || "", i[1] += new Array(f - i[1].length + 1).join("0")), i.join(h)
}

function mParseNumber(number, isPrice = false) {
	let mNumber = number.toString();
	let neg = mNumber.substring(0, 1);
	let float = -1;
	if (isPrice) {
		float = mNumber.indexOf(".");
		mNumber = _.trimStart(mNumber, '-');
	}

	mNumber = mNumber.replace(new RegExp('۰', 'g'), '0');
	mNumber = mNumber.replace(new RegExp('۱', 'g'), '1');
	mNumber = mNumber.replace(new RegExp('۲', 'g'), '2');
	mNumber = mNumber.replace(new RegExp('۳', 'g'), '3');
	mNumber = mNumber.replace(new RegExp('۴', 'g'), '4');
	mNumber = mNumber.replace(new RegExp('٤', 'g'), '4');
	mNumber = mNumber.replace(new RegExp('۵', 'g'), '5');
	mNumber = mNumber.replace(new RegExp('٥', 'g'), '5');
	mNumber = mNumber.replace(new RegExp('٦', 'g'), '6');
	mNumber = mNumber.replace(new RegExp('۶', 'g'), '6');
	mNumber = mNumber.replace(new RegExp('۷', 'g'), '7');
	mNumber = mNumber.replace(new RegExp('۸', 'g'), '8');
	mNumber = mNumber.replace(new RegExp('۹', 'g'), '9');

	if (isPrice) {
		mNumber = mNumber.replace(new RegExp(',', 'g'), '');

		if (mNumber) {
			return ((neg === '-') ? -1 : 1) * ((float !== -1) ? parseFloat(mNumber.split('.')[0] + '.' + ((mNumber.split('.')[1]) ? mNumber.split('.')[1] : '')) : parseInt(mNumber));
		}
	}

	return parseInt(mNumber);
}

function toEnglishNumber(number, isPrice = false) {
	let mNumber = mParseNumber(number, isPrice);
	if (isPrice) {
		if (mNumber.toString().indexOf(".") === -1) {
			return new Intl.NumberFormat('en-US', {
				style: 'decimal',
				minimumFractionDigits: 0,
				maximumFractionDigits: 0
			}).format(mNumber);
		} else {
			return new Intl.NumberFormat('en-US', {
				style: 'decimal',
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			}).format(mNumber);
		}
	}

	return mNumber;
}

function handleInputs() {
	document.querySelectorAll('[data-type]').forEach(element => {
		element.addEventListener('keypress', function (event) {
			const dataType = this.getAttribute('data-type');
			const charCode = (event.which) ? event.which : event.keyCode;

			if (['price', 'number'].includes(dataType)) {
				if (!(!(charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 1776 || charCode > 1785)))) {
					event.preventDefault();
				}
			}

		});

		element.addEventListener('input', function (event) {
			if (!this.value) {
				return '';
			}
			const dataType = this.getAttribute('data-type');
			const min = this.getAttribute('min');
			const max = this.getAttribute('max');

			if (min) {
				if (mParseNumber(this.value) < mParseNumber(min)) {
					this.value = min;
				}
			}

			if (max) {
				if (mParseNumber(this.value) > mParseNumber(max)) {
					this.value = max;
				}
			}

			if (['price', 'number'].includes(dataType)) {
				const converted = toEnglishNumber(this.value, dataType === 'price');
				if (converted !== '') {
					this.value = converted;
				}
			}
		});
	});
}

/**
 * Renew selected items for select2
 * @param items
 * @param targetID
 * @param objectKeys
 * @param childKey
 * @param parentID
 * @param selectedItemsArray
 * @param select2Options
 * @return {boolean}
 */
window.renewSelect2Items = function (items, targetID, objectKeys, select2Options, childKey = '', parentID = 0, selectedItemsArray = []) {
	let filteredItems = [];
	if (!targetID) {
		return false;
	}
	let settingKeys = $.extend({}, {
		id: "id",
		text: 'text'
	}, objectKeys);
	if (childKey) {
		filteredItems = items.filter(function (item) {
			return item[childKey] === parentID;
		});
		if (!filteredItems) {
			filteredItems = [];
		}
	} else {
		filteredItems = items;
	}

	let settingOptions = $.extend({}, {placeholder: false, theme: 'bootstrap-5'}, select2Options);

	let options = filteredItems.map(function (item) {
		let selected = '';
		if (selectedItemsArray.indexOf(item.id + '') > -1 || selectedItemsArray.indexOf(item.id) > -1) {
			selected = 'selected';
		}
		return `<option value="${item[settingKeys.id]}" ${selected}>${item[settingKeys.text]}</option>`;
	});
	if (settingOptions.placeholder) {
		options = [`<option value=""></option>`].concat(options);
	}
	$(targetID).find('option').remove().end();
	$(targetID).append(options.join('\n'));
	$(targetID).select2(settingOptions);
}

/**
 *
 * @param {boolean} isShow
 * @param {"loading"} animFile -  Loading file
 * @param {HTMLElement} parentElement
 */
function toggleLoader(isShow, animFile = 'loading', parentElement = document.body) {
	if (parentElement.id === "contentWrapper") {
		parentElement.classList.add('position-relative');
	}
	if (isShow) {
		const loader = getLoader();
		lottie.loadAnimation({
			container: loader.firstChild, // the dom element that will contain the animation
			renderer: 'svg',
			loop: true,
			autoplay: true,
			path: config.animationsUrl + `/${animFile}.json` // the path to the animation json
		});
		parentElement.appendChild(loader);
	} else {
		const loader = document.querySelector('div.loading');
		if (loader) {
			parentElement.removeChild(loader);
		}
	}
}

function getLoader() {
	const divLoading = mCreateElement({
		element: 'div',
		attributes: [
			{name: "class", value: "loading"}
		]
	});
	const divLoader = mCreateElement({
		element: 'div',
		attributes: [
			{name: "id", value: "loader"}
		]
	});

	divLoading.appendChild(divLoader);

	return divLoading;
}

function getFilterKeyForExcelExport(filterKey) {
	// Remove 'filterInput' prefix
	let newKey = filterKey.replace('filterInput', '');

	// Convert camelCase to snake_case
	return newKey.replace(/([A-Z])/g, '_$1').replace('_', '').toLowerCase();
}