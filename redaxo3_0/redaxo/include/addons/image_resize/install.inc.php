<?php
/**
 * Image-Resize Addon
 *
 * @author office[at]vscope[dot]at Wolfgang Hutteger
 * @author <a href="http://www.vscope.at">www.vscope.at</a>
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 *
 * @package redaxo4
 * @version $Id: install.inc.php,v 1.12 2007/10/28 12:11:24 kills Exp $
 */

$error = '';

if (!extension_loaded('gd'))
{
  $error = 'GD-LIB-extension not available! See <a href="http://www.php.net/gd">http://www.php.net/gd</a>';
}

if ($error != '')
  $REX['ADDON']['installmsg']['image_resize'] = $error;
else
  $REX['ADDON']['install']['image_resize'] = true;
?>