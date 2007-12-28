<?php

/**
 * PHPMailer Addon
 *
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 *
 * @package redaxo4
 * @version $Id: install.inc.php,v 1.1 2007/12/28 10:45:09 kills Exp $
 */

$error = '';

$settings_file = $REX['INCLUDE_PATH'] .'/addons/phpmailer/classes/class.rex_mailer.inc.php';

if(($state = rex_is_writable($settings_file)) !== true)
  $error = $state;

if ($error != '')
  $REX['ADDON']['installmsg']['phpmailer'] = $error;
else
  $REX['ADDON']['install']['phpmailer'] = true;

?>