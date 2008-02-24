<?php

/**
 * Backend Search Addon
 *
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 *
 * @package redaxo4
 * @version $Id: extension_common.inc.php,v 1.3 2008/02/24 16:17:31 kills Exp $
 */

rex_register_extension('PAGE_HEADER', 'rex_a256_insertCss');

/**
 * Fügt den nötigen JS-Code ein
 */
function rex_a256_insertCss($params)
{
	global $REX;

	$content = $params['subject'];

	$cssfile = $REX['INCLUDE_PATH'] .'/addons/be_search/css/be_search.css';
  $cssContent = rex_get_file_contents($cssfile);

  $css ='
    <!-- Backend Search CSS //-->
	  <style type="text/css">
	  <!--
	  '. $cssContent .'
	  //-->
	  </style>
    <!-- End Backend Search CSS //-->
  ';

  return $content . $css;
}

?>