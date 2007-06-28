<?php

/** 
 * Addonlist
 * @package redaxo3 
 * @version $Id: addons.inc.php,v 1.7 2007/06/28 10:06:15 kills Exp $ 
 */ 

// ----------------- addons
if (isset($REX['ADDON']['status'])) {
  unset($REX['ADDON']['status']);
}

// ----------------- DONT EDIT BELOW THIS
// --- DYN

// --- /DYN
// ----------------- /DONT EDIT BELOW THIS

if(!isset($REX['ADDON']) || !is_array($REX['ADDON']))
{
  $REX['ADDON'] = array();
  $REX['ADDON']['install'] = array();
  $REX['ADDON']['status'] = array();
}
  
for($i=0;$i<count($REX['ADDON']['status']);$i++)
{
	if (current($REX['ADDON']['status']) == 1) include $REX['INCLUDE_PATH']."/addons/".key($REX['ADDON']['status'])."/config.inc.php";
	next($REX['ADDON']['status']);
}

// ----- all addons configs included
rex_register_extension_point( 'ADDONS_INCLUDED');

?>