/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function (config) {
	config.language = 'fa';
	config.font_names = 'ایران سنس/IRANSans';
	config.extraPlugins = 'internallink';
	config.allowedContent = true;
	config.extraPlugins = 'autosave';
	config.autosave_saveOnDestroy = true;
	config.autosave_delay = 20;
	config.autosave_saveDetectionSelectors = "a[href^='javascript:__doPostBack'][id*='Save'],a[id*='Cancel']";
	config.height = '400px';
	config.toolbarGroups = [
		{name: 'document', groups: ['mode', 'document', 'doctools']},
		{name: 'clipboard', groups: ['clipboard', 'undo']},
		{name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
		{name: 'forms', groups: ['forms']},
		'/',
		{name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
		{name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
		{name: 'links', groups: ['links']},
		{name: 'insert', groups: ['insert']},
		'/',
		{name: 'styles', groups: ['styles']},
		{name: 'colors', groups: ['colors']},
		{name: 'tools', groups: ['tools']},
		{name: 'others', groups: ['others']},
		{name: 'about', groups: ['about']}
	];
	config.removeButtons = 'Flash,Smiley,Iframe,About,Save,Preview,HiddenField,ImageButton,Button,Select,Textarea,TextField,Radio,Checkbox,Form,Language,Styles';
	config.extraPlugins = 'image2,btgrid,wordcount,notification,autosave';
	config.allowedContent = true
	config.wordcount = {
		// Whether or not you want to show the Paragraphs Count
		showParagraphs: true,

		// Whether or not you want to show the Word Count
		showWordCount: true,

		// Whether or not you want to show the Char Count
		showCharCount: true,

		// Whether or not you want to count Spaces as Chars
		countSpacesAsChars: true,

		// Whether or not to include Html chars in the Char Count
		countHTML: false,

		// Maximum allowed Word Count, -1 is default for unlimited
		maxWordCount: -1,

		// Maximum allowed Char Count, -1 is default for unlimited
		maxCharCount: -1,

		// Add filter to add or remove element before counting (see CKEDITOR.htmlParser.filter), Default value : null (no filter)
		filter: new CKEDITOR.htmlParser.filter({
			elements: {
				div: function (element) {
					if (element.attributes.class == 'mediaembed') {
						return false;
					}
				}
			}
		})
	};
};
