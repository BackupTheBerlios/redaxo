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
 * @version $Id: config.inc.php,v 1.6 2007/03/28 18:07:39 kills Exp $
 */

$mypage = "tinymce";

$REX['ADDON']['rxid'][$mypage] = "52";
$REX['ADDON']['page'][$mypage] = $mypage;
$REX['ADDON']['name'][$mypage] = "TinyMCE";
$REX['ADDON']['perm'][$mypage] = "tiny_mce[]";

// Include tinylib
if($REX['REDAXO'])
{
	include_once $REX['INCLUDE_PATH'].'/addons/tinymce/classes/class.tiny.inc.php';
}
?>