<?php

/**
 * Textile Addon
 *  
 * @author staab[at]public-4u[dot]de Markus Staab
 * @author <a href="http://www.public-4u.de">www.public-4u.de</a>
 * @package redaxo3
 * @version $Id: config.inc.php,v 1.6 2007/05/07 12:26:54 tbaddade Exp $
 */

$mypage = 'textile';

$REX['ADDON']['rxid'][$mypage] = '79';
$REX['ADDON']['page'][$mypage] = $mypage;    
$REX['ADDON']['name'][$mypage] = 'Textile';
$REX['ADDON']['perm'][$mypage] = 'textile[]';

$REX['PERM'][] = 'textile[]';
$I18N_A79 = new i18n($REX['LANG'], $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/lang/'); 

require_once($REX['INCLUDE_PATH']. '/addons/textile/classes/class.textile.inc.php');
require_once $REX['INCLUDE_PATH']. '/addons/textile/functions/function_textile.inc.php';

if ($REX['REDAXO'])
{
  require_once $REX['INCLUDE_PATH'].'/addons/textile/functions/function_help.inc.php';
  
  // perms laden und hinzufügen
  foreach(rex_a79_help_overview_perms() as $perm)
  {
    $REX['EXTRAPERM'][] = $perm;
  }
}
 
?>