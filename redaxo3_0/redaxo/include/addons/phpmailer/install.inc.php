<?php

/**
 * PHPMailer Addon
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 *
 * @package redaxo4
 * @version $Id: install.inc.php,v 1.5 2007/10/31 18:28:27 kills Exp $
 */

$error = '';

if(($state = rex_is_writable($settings_file)) !== true)
  $error = $state;

if ($error != '')
  $REX['ADDON']['installmsg']['phpmailer'] = $error;
else
  $REX['ADDON']['install']['phpmailer'] = true;

?>