<?php

/**
 * Backend Search Addon
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 *
 * @package redaxo4
 * @version $Id: install.inc.php,v 1.1 2007/12/29 17:57:05 kills Exp $
 */

$error = '';

if ($error != '')
  $REX['ADDON']['installmsg']['be_search'] = $error;
else
  $REX['ADDON']['install']['be_search'] = true;
?>