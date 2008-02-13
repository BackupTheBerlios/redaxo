<?php

/**
 * Klasse zum pr�fen ob Addons installiert/aktiviert sind
 * @package redaxo4
 * @version $Id: class.ooaddon.inc.php,v 1.2 2008/02/13 10:08:12 kills Exp $
 */

class OOAddon
{
  function isAvailable($addon)
  {
    return OOAddon::isInstalled($addon) && OOAddon::isActivated($addon);
  }

  function isActivated($addon)
  {
    return OOAddon::_getProperty($addon, 'status') == 1;
  }
  function isInstalled($addon)
  {
    return OOAddon::_getProperty($addon, 'install') == 1;
  }

  function isSystemAddon($addon)
  {
    global $REX;
    return in_array($addon, $REX['SYSTEM_ADDONS']);
  }

  function getVersion($addon, $default = null)
  {
    return OOAddon::_getProperty($addon, 'version', $default);
  }

  function getAuthor($addon, $default = null)
  {
    return OOAddon::_getProperty($addon, 'author', $default);
  }

  function getSupportPage($addon, $default = null)
  {
    return OOAddon::_getProperty($addon, 'supportpage', $default);
  }

  function _getProperty($addon, $property, $default = null)
  {
    global $REX;
    return isset($REX['ADDON'][$property][$addon]) ? $REX['ADDON'][$property][$addon] : $default;
  }
}
?>