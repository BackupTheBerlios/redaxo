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
 * @version $Id: uninstall.inc.php,v 1.3 2007/03/28 18:07:40 kills Exp $
 */

rex_deleteDir('../files/tinymce', true);

$REX['ADDON']['install']['tinymce'] = 0;
?>