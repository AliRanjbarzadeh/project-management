// ckeditor.js

import {ClassicEditor as ClassicEditorBase} from '@ckeditor/ckeditor5-editor-classic';
import {Essentials} from '@ckeditor/ckeditor5-essentials';
import {Autoformat} from '@ckeditor/ckeditor5-autoformat';
import {Bold, Italic, Strikethrough, Subscript, Superscript, Underline} from '@ckeditor/ckeditor5-basic-styles';
import {BlockQuote} from '@ckeditor/ckeditor5-block-quote';
import {Heading, HeadingButtonsUI} from '@ckeditor/ckeditor5-heading';
import {Link, LinkImage} from '@ckeditor/ckeditor5-link';
import {List, TodoList} from '@ckeditor/ckeditor5-list';
import {Paragraph} from '@ckeditor/ckeditor5-paragraph';
import {HorizontalLine} from "@ckeditor/ckeditor5-horizontal-line";
import {FontBackgroundColor, FontColor, FontFamily} from "@ckeditor/ckeditor5-font";
import {Image, ImageInsert, ImageResize, ImageStyle, ImageTextAlternative, ImageToolbar} from "@ckeditor/ckeditor5-image";
import {MediaEmbed} from "@ckeditor/ckeditor5-media-embed";
import {Alignment} from "@ckeditor/ckeditor5-alignment";
import {PageBreak} from "@ckeditor/ckeditor5-page-break";
import {RemoveFormat} from "@ckeditor/ckeditor5-remove-format";
import {SpecialCharacters} from "@ckeditor/ckeditor5-special-characters";
import {Highlight} from "@ckeditor/ckeditor5-highlight";
import {Indent} from "@ckeditor/ckeditor5-indent";
import {Table} from "@ckeditor/ckeditor5-table";
import {FindAndReplace} from "@ckeditor/ckeditor5-find-and-replace";
import {SourceEditing} from "@ckeditor/ckeditor5-source-editing";
import {SimpleUploadAdapter} from "@ckeditor/ckeditor5-upload";
import {HtmlEmbed} from "@ckeditor/ckeditor5-html-embed";
import "./fa.js";
import "@ckeditor/ckeditor5-alignment/build/translations/fa.js";
import "@ckeditor/ckeditor5-font/build/translations/fa.js";
import "@ckeditor/ckeditor5-basic-styles/build/translations/fa.js";
import "@ckeditor/ckeditor5-remove-format/build/translations/fa.js";
import "@ckeditor/ckeditor5-highlight/build/translations/fa.js";
import "@ckeditor/ckeditor5-block-quote/build/translations/fa.js";
import "@ckeditor/ckeditor5-page-break/build/translations/fa.js";
import "@ckeditor/ckeditor5-horizontal-line/build/translations/fa.js";
import "@ckeditor/ckeditor5-find-and-replace/build/translations/fa.js";
import "@ckeditor/ckeditor5-special-characters/build/translations/fa.js";
import "@ckeditor/ckeditor5-html-embed/build/translations/fa.js";
import {BlockToolbar} from "@ckeditor/ckeditor5-ui";
import { PasteFromOffice } from '@ckeditor/ckeditor5-paste-from-office';

export default class ClassicEditor extends ClassicEditorBase {
}

ClassicEditor.builtinPlugins = [
	Essentials,
	Autoformat,
	Bold,
	Underline,
	Italic,
	BlockQuote,
	BlockToolbar,
	Heading,
	Link,
	List,
	Paragraph,
	HorizontalLine,
	FontBackgroundColor,
	FontColor,
	FontFamily,
	MediaEmbed,
	Image,
	LinkImage,
	ImageInsert,
	ImageResize,
	ImageTextAlternative,
	ImageToolbar,
	ImageStyle,
	Alignment,
	PageBreak,
	Strikethrough,
	Subscript,
	Superscript,
	RemoveFormat,
	SpecialCharacters,
	Highlight,
	TodoList,
	Indent,
	Table,
	FindAndReplace,
	SourceEditing,
	SimpleUploadAdapter,
	HtmlEmbed,
	HeadingButtonsUI,
	PasteFromOffice
];

ClassicEditor.defaultConfig = {
	toolbar: {
		items: [
			"heading", "|",
			"alignment", "pageBreak", "horizontalLine", "|",
			"fontBackgroundColor", "fontColor", "fontFamily", "|",
			"link", "imageInsert", "mediaEmbed", "htmlEmbed", "|",
			"bold", "underline", "italic", "strikethrough", "subscript", "superscript", "|",
			"removeFormat", "highlight", "bulletedList", "numberedList", "todoList", "outdent", "indent", "|",
			"blockQuote", "insertTable", "|",
			"findAndReplace", "selectAll", "|",
			"sourceEditing", "undo", "redo",
		]
	},
	image: {
		toolbar: [
			'imageStyle:alignLeft',
			'imageStyle:alignRight',
			"|",
			"imageTextAlternative",
			"imageResize",
		],
		styles: ['full', 'alignLeft', 'alignRight']
	},
	heading: {
		options: [
			{ model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
			{ model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
			{ model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
			{ model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
			{ model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
			{ model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' }
		]
	},
	language: {
		ui: 'fa',
		content: window.directionLocale
	},
};
