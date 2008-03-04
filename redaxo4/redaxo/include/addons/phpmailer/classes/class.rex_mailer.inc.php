<?php

/**
 * PHPMailer Addon
 *  
 * @author markus[dot]staab[at]redaxo[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * 
 * @package redaxo4
 * @version $Id: class.rex_mailer.inc.php,v 1.2 2008/03/04 15:01:08 kills Exp $
 */

class rex_mailer extends PHPMailer
{
  function rex_mailer()
  {
    global $REX;

    // --- DYN
    $this->From     = 'from@example.com';
    $this->FromName = 'Mailer';
    $this->ConfirmReadingTo = '';
    $this->Mailer   = 'sendmail';
    $this->Host     = 'localhost';
    $this->CharSet  = 'iso-8859-1';
    $this->WordWrap = 75;
    $this->Encoding = '8bit';
    $this->Priority = 3;
    // --- /DYN

    $this->PluginDir = $REX['INCLUDE_PATH'] . '/addons/phpmailer/classes/';
  }

  function SetLanguage($lang_type, $lang_path = null)
  {
    global $REX;

    if ($lang_path == null)
      $lang_path = $REX['INCLUDE_PATH'] . '/addons/phpmailer/classes/language/';

    parent :: SetLanguage($lang_type, $lang_path);
  }
}
?>