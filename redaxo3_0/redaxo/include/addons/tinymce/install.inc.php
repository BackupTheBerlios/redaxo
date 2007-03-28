<?php

/**
 * TinyMCE Addon
 *  
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * 
 * @author Dave Holloway
 * @author <a href="http://www.GN2-Netwerk.de">www.GN2-Netwerk.de</a>s
 * 
 * @package redaxo3
 * @version $Id: install.inc.php,v 1.8 2007/03/28 18:07:40 kills Exp $
 */

require_once $REX['INCLUDE_PATH'] . '/addons/tinymce/functions/function_pclzip.inc.php';

// Install Tiny Core
rex_a52_extract_archive('include/addons/tinymce/js/tinymce.zip');
// Install German Language Pack
rex_a52_extract_archive('include/addons/tinymce/js/tinymce_lang_de.zip');

$REX['ADDON']['install']['tinymce'] = true;

?>