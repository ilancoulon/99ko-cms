<?php 
header('Content-type: text/css');
ob_start("minify");
	function minify($buffer) {
		/* Suprimme les commentaires */
    	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);    		
    	/* suprimme les tabs, espaces, saut de ligne, etc. */
    	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);   		
    	return $buffer;
	}
  	/* Fichier css à compresser */
  	include('normalize.css');
  	include('foundation.css');
  	include('99ko.css');
ob_end_flush();
?>
