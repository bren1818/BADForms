/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	config.extraPlugins = 'wordcount';
	config.wordcount = {
		// Whether or not you want to show the Word Count
		showWordCount: true,
		wordlimit: 300,
		
		showCharCount: true,
		countHTML: false
	};
};
