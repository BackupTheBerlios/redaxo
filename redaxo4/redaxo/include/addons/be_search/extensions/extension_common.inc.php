<?php

/**
 * Backend Search Addon
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo4
 * @version $Id: extension_common.inc.php,v 1.1 2007/12/29 17:57:05 kills Exp $
 */

rex_register_extension('PAGE_HEADER', 'rex_a256_insertCss');

/**
 * F�gt den n�tigen JS-Code ein
 */
function rex_a256_insertCss($params)
{
	global $REX;

	$content = $params['subject'];

	$cssfile = $REX['INCLUDE_PATH'] .'/addons/be_search/css/be_search.css';
  $cssContent = rex_get_file_contents($cssfile);

  $css ='
    <!-- Backend Search CSS //-->
	  <script type="text/javascript">
	  <!--
	  '. $cssContent .'
	  //-->
	  </script>
    <!-- End Backend Search CSS //-->
  ';

  return $content . $css;
}

?>