include("/mozbar/activebar-2.0.1/src/activebar2.js");
include("/mozbar/cookies.js");



$j = jQuery.noConflict();
//$j(function() {
$j(document).ready(function() {
	// Everything inside this function will be automatically executed 
        // after the page has been loaded and the DOM is complete 
	if($j.browser.msie && parseInt($j.browser.version) < 7)
	$j('<div></div>').html('<span color="#FFFFFF#">Votre navigateur ne permet pas de profiter de ce site de mani&egrave;re optimale. Veuillez mettre &agrave jour votre navigateur ou utiliser <span style="text-decoration:underline;"><b>Mozilla Firefox 3.6</b></span></span>.').activebar({
	      'fontColor': '#FFFFFF',
              'font': 'Bitstream Vera Sans,verdana,sans-serif',
              'icon': '/mozbar/images/error.gif',
              'button': '/mozbar/activebar-2.0.1/images/activebar-closebtn.png',
              'highlight': 'rgb(51,153,255)',
              'background': '#c8270d',
              'border': '#FFFFFF',   
              'url': 'http://www.mozilla.com/en-US/?from=sfx&uid=311697&t=581',
	      'onReady': function() { setTimeout('$j.fn.activebar.hide()',5000); }
	});
});

/*****************************************************
inclu un autre fichier js
*****************************************************/
function include(file) {
   if (document.createElement && document.getElementsByTagName) {
     var head = document.getElementsByTagName('head')[0];

     var script = document.createElement('script');
     script.setAttribute('type', 'text/javascript');
     script.setAttribute('src', file);

     head.appendChild(script);
   } 
 }


