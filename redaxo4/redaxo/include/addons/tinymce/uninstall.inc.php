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
 * @package redaxo4
 * @version $Id: uninstall.inc.php,v 1.1 2007/12/28 10:45:09 kills Exp $
 */

rex_deleteDir('../files/tmp_/tinymce', true);

$REX['ADDON']['install']['tinymce'] = 0;
?>