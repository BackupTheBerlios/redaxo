<?php

/** 
 * Klasse zum pr�fen ob Addons installiert/aktiviert sind
 * @package redaxo3 
 * @version $Id: class.ooaddon.inc.php,v 1.1 2008/03/26 13:35:37 kills Exp $ 
 */ 

class OOAddon
{
  function isAvailable($addon)
  {
    return OOAddon::isInstalled($addon) && OOAddon::isActivated($addon);
  }

  function isActivated($addon)
  {
    global $REX;
    return isset( $REX['ADDON']['status'][$addon]) && $REX['ADDON']['status'][$addon] == 1;
  }
  function isInstalled($addon)
  {
    global $REX;
    return isset( $REX['ADDON']['install'][$addon]) && $REX['ADDON']['install'][$addon] == 1;
  }
}
?>