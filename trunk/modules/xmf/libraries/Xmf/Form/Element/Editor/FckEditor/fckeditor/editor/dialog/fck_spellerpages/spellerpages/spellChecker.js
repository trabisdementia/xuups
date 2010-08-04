﻿////////////////////////////////////////////////////
// spellChecker.js
//
// spellChecker object
//
// This file is sourced on web pages that have a textarea object to evaluate
// for spelling. It includes the implementation for the spellCheckObject.
//
////////////////////////////////////////////////////


// constructor
function spellChecker( textObject ) {

	// public properties - configurable
//	this.popUpUrl = '/speller/spellchecker.html';							// by FredCK
	this.popUpUrl = 'fck_spellerpages/spellerpages/spellchecker.html';		// by FredCK
	this.popUpName = 'spellchecker';
//	this.popUpProps = "menu=no,width=440,height=350,top=70,left=120,resizable=yes,status=yes";	// by FredCK
	this.popUpProps = null ;																	// by FredCK
//	this.spellCheckScript = '/speller/server-scripts/spellchecker.php';		// by FredCK
	//this.spellCheckScript = '/cgi-bin/spellchecker.pl';

	// values used to keep track of what happened to a word
	this.replWordFlag = "R";	// single replace
	this.ignrWordFlag = "I";	// single ignore
	this.replAllFlag = "RA";	// replace all occurances
	this.ignrAllFlag = "IA";	// ignore all occurances
	this.fromReplAll = "~RA";	// an occurance of a "replace all" word
	this.fromIgnrAll = "~IA";	// an occurance of a "ignore all" word
	// properties set at run time
	this.wordFlags = new Array();
	this.currentTextIndex = 0;
	this.currentWordIndex = 0;
	this.spellCheckerWin = null;
	this.controlWin = null;
	this.wordWin = null;
	this.textArea = textObject;	// deprecated
	this.textInputs = arguments;

	// private methods
	this._spellcheck = _spellcheck;
	this._getSuggestions = _getSuggestions;
	this._setAsIgnored = _setAsIgnored;
	this._getTotalReplaced = _getTotalReplaced;
	this._setWordText = _setWordText;
	this._getFormInputs = _getFormInputs;

	// public methods
	this.openChecker = openChecker;
	this.startCheck = startCheck;
	this.checkTextBoxes = checkTextBoxes;
	this.checkTextAreas = checkTextAreas;
	this.spellCheckAll = spellCheckAll;
	this.ignoreWord = ignoreWord;
	this.ignoreAll = ignoreAll;
	this.replaceWord = replaceWord;
	this.replaceAll = replaceAll;
	this.terminateSpell = terminateSpell;
	this.undo = undo;

	// set the current window's "speller" property to the instance of this class.
	// this object can now be referenced by child windows/frames.
	window.speller = this;
}

// call this method to check all text boxes (and only text boxes) in the HTML document
function checkTextBoxes() {
	this.textInputs = this._getFormInputs( "^text$" );
	this.openChecker();
}

// call this method to check all textareas (and only textareas ) in the HTML document
function checkTextAreas() {
	this.textInputs = this._getFormInputs( "^textarea$" );
	this.openChecker();
}

// call this method to check all text boxes and textareas in the HTML document
function spellCheckAll() {
	this.textInputs = this._getFormInputs( "^text(area)?$" );
	this.openChecker();
}

// call this method to check text boxe(s) and/or textarea(s) that were passed in to the
// object's constructor or to the textInputs property
function openChecker() {
	this.spellCheckerWin = window.open( this.popUpUrl, this.popUpName, this.popUpProps );
	if( !this.spellCheckerWin.opener ) {
		this.spellCheckerWin.opener = window;
	}
}

function startCheck( wordWindowObj, controlWindowObj ) {

	// set properties from args
	this.wordWin = wordWindowObj;
	this.controlWin = controlWindowObj;

	// reset properties
	this.wordWin.resetForm();
	this.controlWin.resetForm();
	this.currentTextIndex = 0;
	this.currentWordIndex = 0;
	// initialize the flags to an array - one element for each text input
	this.wordFlags = new Array( this.wordWin.textInputs.length );
	// each element will be an array that keeps track of each word in the text
	for( var i=0; i<this.wordFlags.length; i++ ) {
		this.wordFlags[i] = [];
	}

	// start
	this._spellcheck();

	return true;
}

function ignoreWord() {
	var wi = this.currentWordIndex;
	var ti = this.currentTextIndex;
	if( !this.wordWin ) {
		alert( 'Error: Word frame not available.' );
		return false;
	}
	if( !this.wordWin.getTextVal( ti, wi )) {
		alert( 'Error: "Not in dictionary" text is missing.' );
		return false;
	}
	// set as ignored
	if( this._setAsIgnored( ti, wi, this.ignrWordFlag )) {
		this.currentWordIndex++;
		this._spellcheck();
	}
	return true;
}

function ignoreAll() {
	var wi = this.currentWordIndex;
	var ti = this.currentTextIndex;
	if( !this.wordWin ) {
		alert( 'Error: Word frame not available.' );
		return false;
	}
	// get the word that is currently being evaluated.
	var s_word_to_repl = this.wordWin.getTextVal( ti, wi );
	if( !s_word_to_repl ) {
		alert( 'Error: "Not in dictionary" text is missing' );
		return false;
	}

	// set this word as an "ignore all" word.
	this._setAsIgnored( ti, wi, this.ignrAllFlag );

	// loop through all the words after this word
	for( var i = ti; i < this.wordWin.textInputs.length; i++ ) {
		for( var j = 0; j < this.wordWin.totalWords( i ); j++ ) {
			if(( i == ti && j > wi ) || i > ti ) {
				// future word: set as "from ignore all" if
				// 1) do not already have a flag and
				// 2) have the same value as current word
				if(( this.wordWin.getTextVal( i, j ) == s_word_to_repl )
				&& ( !this.wordFlags[i][j] )) {
					this._setAsIgnored( i, j, this.fromIgnrAll );
				}
			}
		}
	}

	// finally, move on
	this.currentWordIndex++;
	this._spellcheck();
	return true;
}

function replaceWord() {
	var wi = this.currentWordIndex;
	var ti = this.currentTextIndex;
	if( !this.wordWin ) {
		alert( 'Error: Word frame not available.' );
		return false;
	}
	if( !this.wordWin.getTextVal( ti, wi )) {
		alert( 'Error: "Not in dictionary" text is missing' );
		return false;
	}
	if( !this.controlWin.replacementText ) {
		return false ;
	}
	var txt = this.controlWin.replacementText;
	if( txt.value ) {
		var newspell = new String( txt.value );
		if( this._setWordText( ti, wi, newspell, this.replWordFlag )) {
			this.currentWordIndex++;
			this._spellcheck();
		}
	}
	return true;
}

function replaceAll() {
	var ti = this.currentTextIndex;
	var wi = this.currentWordIndex;
	if( !this.wordWin ) {
		alert( 'Error: Word frame not available.' );
		return false;
	}
	var s_word_to_repl = this.wordWin.getTextVal( ti, wi );
	if( !s_word_to_repl ) {
		alert( 'Error: "Not in dictionary" text is missing' );
		return false;
	}
	var txt = this.controlWin.replacementText;
	if( !txt.value ) return false;
	var newspell = new String( txt.value );

	// set this word as a "replace all" word.
	this._setWordText( ti, wi, newspell, this.replAllFlag );

	// loop through all the words after this word
	for( var i = ti; i < this.wordWin.textInputs.length; i++ ) {
		for( var j = 0; j < this.wordWin.totalWords( i ); j++ ) {
			if(( i == ti && j > wi ) || i > ti ) {
				// future word: set word text to s_word_to_repl if
				// 1) do not already have a flag and
				// 2) have the same value as s_word_to_repl
				if(( this.wordWin.getTextVal( i, j ) == s_word_to_repl )
				&& ( !this.wordFlags[i][j] )) {
					this._setWordText( i, j, newspell, this.fromReplAll );
				}
			}
		}
	}

	// finally, move on
	this.currentWordIndex++;
	this._spellcheck();
	return true;
}

function terminateSpell() {
	// called when we have reached the end of the spell checking.
	var msg = "";		// by FredCK
	var numrepl = this._getTotalReplaced();
	if( numrepl == 0 ) {
		// see if there were no misspellings to begin with
		if( !this.wordWin ) {
			msg = "";
		} else {
			if( this.wordWin.totalMisspellings() ) {
//				msg += "No words changed.";			// by FredCK
				msg += FCKLang.DlgSpellNoChanges ;	// by FredCK
			} else {
//				msg += "No misspellings found.";	// by FredCK
				msg += FCKLang.DlgSpellNoMispell ;	// by FredCK
			}
		}
	} else if( numrepl == 1 ) {
//		msg += "One word changed.";			// by FredCK
		msg += FCKLang.DlgSpellOneChange ;	// by FredCK
	} else {
//		msg += numrepl + " words changed.";	// by FredCK
		msg�����������������U��������������������������iii��������������������������l���f���l���[���W���Y���Y���Y���X���L���d�������� ���    4����������������������������������������������������������������������������ӕ��֑�������������������������������������������g���a���k���f���]���Y���Y���Y���Y���W���J��UCo��W�������� ���    4���������������������������������������������������������������������������������p�����������������������������������|���W���j���u���a���^���^���]���[���Y���Y���R��l=��t����]���P��������    4��������������������������������������������������������������������������������Ð���`���������������������������M���h��Ӂ���j���c���c���b���`���^���]���]���Y���W���^���`���P���L���������    4����������������������������������������������������������������������������XD_�-/�y2|��o���������������k���^���|��Ճ���h���h���h���f���c���b���b���`���N���Z���[���V���O��7I[��U���J��vowF   4���������������������������������������������������������������������n��,.��$&�
� ������x���J���}��؎���w���o���o���l���i���h���f���f���\��O(Q��n4r��[���V���O��h����g���I��S��   4�����������������������������������������������������������������U���Y��b2f��,.�
�@C��A���o��ܙ��ܒ���z���z���v���s���p���m���m���f���E��$%��##��p5t��[���[���[���S���S���l��   4�������������������������������������������������������������u���L���Y���E��0$1�X?Z�r6w��_��ޡ��ߚ��ی��ن��؆��ր���{���x���w���q���V��0"1��'(�*+�)*�%&��W(Z��W���W���Z���W���O��   4������������������������������������������������������������Ȳ���Q���W���S��l5p��c��ݟ��������ޕ��ݒ��ێ��ډ��؆��׃��ր���b��U7V�'$'�-'.�3(4�1&2�-".�, ,�++�!"��l>o��Z���Q���J���D��   4�����������������������������������������������������������������R���K���J���z���������ޖ��ߚ������ߘ��ޕ��ܐ��ڎ��؃���U��.*.�0-0�<3=�;0<�6+6�3)4�3'3�- -�#$�0+/�_Na��R���N���J���L�j�H�   4�����������������������������������������������������������������\���o��ܘ�����ܑ��ۍ��ۍ��ۋ��ی��܏��ܐ��ܐ���n��]J]�:9:�D<D�F;F�A7A�=4>�;1<�8+8�++�'!(�D;E�pGt��U���L���K���M���� ���    4�����������������������������������������������������������������������ߙ��ޖ��ޕ��ݓ��ܑ��܏��ی��ډ���z��qMq�546�HDH�PGP�OFO�LBL�H>H�F;F�;2<�1'1�OGP���������D(G�Z0^�B�;��� ��� ��� ���    4�����������������������������������������������������������������������ݔ��ߘ��ޗ��ޖ��ݔ��ܑ��ۍ��|\z�PNP�PNP�RHR�E;D�;2;�909�C:C�E;E�-&.�=6>������������������~��		��� ��� ��� ��� ���    4���������������������������������������������������������������������������ߘ��ߘ��ޗ��ޖ��ݒ��Օ��tvt�unu�kbk�^T^�SIS�H?H�=4=�*!*�)"(�f_g�������������������������lkl��� ��� ��� ��� ���    4����������������������������������������������������������������������������ޖ��ߙ��ߙ��ޗ��ݓ��ߚ�������}��zqz�ndn�aXa�PFP�92:�VOX��������������������������������������� ��� ��� ��� ���    4�������������������������������������������������������������������������������ߙ��ߚ��ߙ��ޗ��ޕ��ī����������|r|�ici�php������������������������������������������������(��� ��� ��� ���    4��������������������������������������������������������������������������������ߙ������ߚ��ߙ��ܑ���������������������������������������������������������������������Խ�_��� ��� ��� ���    2������������������������������������������������������������������������������������ޕ������ߚ��ޖ�����������ÿ������V��͡��������������������������������������ʏ���O���\�������� ��� ���    (�������������������������������������������������������������������������������������|�������������ߙ��է��Â���A���L���������������������������������������f���Q���d���V��Սڟ������ ���    " "" "! !! !! !! !! !! !! !! !! !! !! !! !! !! !! !! !! !! !969�d��ڌ���������x���G���8���?��O.S#! !|p}F�����������������������^.).�f���j���h���[���W�������� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ؘ�E�m��ډ���i���<���=�ڒ?�b��� ��� ��� ��� �����������֪���b�����\��� �x�M�m���a���r��̊�X������ ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� Ց��_�~�6��:�a�<���� ��� ��� ��� ��� ��������s���q���w��ֈ�������� �~�jמ�]ۥ���� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� �V���� ��� ��� ��� ��� ��� ��� ��� ߘ�J؂��؆��؄���o����������� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ܐ��؅���z���g��Ή�G������ ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ��� ���                                                                                                                                                                                                                                                                                                             ����  �����  �����  �����  ������  ������%�(       @                                 7l7n�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�7:�VZ�   D��� ��� ���    &ӄ���f���f���e���b���]���Y���V���R���N���K���H���E���B���?���<���;���:���9���9���8���5���2���0���.���/��p%u�   6��� ��� ���    %�����^���\���]�������^�������V���������������G����������Պ���<���������������9���8�������3���1�����������}��   5��� ��� ���    %�����c���\���V�������Q�������P�������P���N���J���F���D�������=�������:���9���9���7�������4���1���/��{4~�����   5��� ��� ���    %������������X�����������w���G�����������M���M��ۙ������ؖ���?�����������:���8���8�������6���4��ŋ����������   5��� ��� ���    %�����n�������]�������Q�������H�������B���C���F�������G���F���B�������;���;���:���8�������7���6�������7��w'|�   5��� ��� ���    %������������d����������ܝ���J���������������B��׎�����������C���������������:���������������6��Ɇ����������   5��� ��� ���    %ۚ��Ԅ���~���v���n���h���c���]���Z���Y���Y���X���X���W���V���S���R���U���M���~���Q���O���M���L���L���K���5��   5��� ��� ���    %����������������������