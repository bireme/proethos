// JavaScript Document
/* ---------------------------------------------------------------------- */
/* Language Switcher
/* ----------------------------------------------------------------------
 Version: 0.14.43 
 Author: Rene Faustino Gabriel Junior <renefgj@gmail.com>
 ------------------------------------------------------------------------- */

$("#LanguageSwitcher").change(function () { 
	var langague = $( "#LanguageSwitcher option:selected" ).val();
	var pathname = window.location.pathname; // returns path only
	var url      = window.location.href;     // returns full url
	page = url + '/' + langague;
	window.location.replace(page);
});
